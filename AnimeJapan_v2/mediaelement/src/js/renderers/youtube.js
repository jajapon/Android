'use strict';

import window from 'global/window';
import document from 'global/document';
import mejs from '../core/mejs';
import {renderer} from '../core/renderer';
import {createEvent, addEvent} from '../utils/dom';
import {typeChecks} from '../utils/media';

/**
 * YouTube renderer
 *
 * Uses <iframe> approach and uses YouTube API to manipulate it.
 * Note: IE6-7 don't have postMessage so don't support <iframe> API, and IE8 doesn't fire the onReady event,
 * so it doesn't work - not sure if Google problem or not.
 * @see https://developers.google.com/youtube/iframe_api_reference
 */
const YouTubeApi = {
	/**
	 * @type {Boolean}
	 */
	isIframeStarted: false,
	/**
	 * @type {Boolean}
	 */
	isIframeLoaded: false,
	/**
	 * @type {Array}
	 */
	iframeQueue: [],

	/**
	 * Create a queue to prepare the creation of <iframe>
	 *
	 * @param {Object} settings - an object with settings needed to create <iframe>
	 */
	enqueueIframe: (settings) => {

		if (YouTubeApi.isLoaded) {
			YouTubeApi.createIframe(settings);
		} else {
			YouTubeApi.loadIframeApi();
			YouTubeApi.iframeQueue.push(settings);
		}
	},

	/**
	 * Load YouTube API script on the header of the document
	 *
	 */
	loadIframeApi: () => {
		if (!YouTubeApi.isIframeStarted) {
			let tag = document.createElement('script');
			tag.src = '//www.youtube.com/player_api';
			let firstScriptTag = document.getElementsByTagName('script')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
			YouTubeApi.isIframeStarted = true;
		}
	},

	/**
	 * Process queue of YouTube <iframe> element creation
	 *
	 */
	iFrameReady: () => {

		YouTubeApi.isLoaded = true;
		YouTubeApi.isIframeLoaded = true;

		while (YouTubeApi.iframeQueue.length > 0) {
			let settings = YouTubeApi.iframeQueue.pop();
			YouTubeApi.createIframe(settings);
		}
	},

	/**
	 * Create a new instance of YouTube API player and trigger a custom event to initialize it
	 *
	 * @param {Object} settings - an object with settings needed to create <iframe>
	 */
	createIframe: (settings) => {
		return new YT.Player(settings.containerId, settings);
	},

	/**
	 * Extract ID from YouTube's URL to be loaded through API
	 * Valid URL format(s):
	 * - http://www.youtube.com/watch?feature=player_embedded&v=yyWWXSwtPP0
	 * - http://www.youtube.com/v/VIDEO_ID?version=3
	 * - http://youtu.be/Djd6tPrxc08
	 * - http://www.youtube-nocookie.com/watch?feature=player_embedded&v=yyWWXSwtPP0
	 *
	 * @param {String} url
	 * @return {string}
	 */
	getYouTubeId: (url) => {

		let youTubeId = "";

		if (url.indexOf('?') > 0) {
			// assuming: http://www.youtube.com/watch?feature=player_embedded&v=yyWWXSwtPP0
			youTubeId = YouTubeApi.getYouTubeIdFromParam(url);

			// if it's http://www.youtube.com/v/VIDEO_ID?version=3
			if (youTubeId === '') {
				youTubeId = YouTubeApi.getYouTubeIdFromUrl(url);
			}
		} else {
			youTubeId = YouTubeApi.getYouTubeIdFromUrl(url);
		}

		return youTubeId;
	},

	/**
	 * Get ID from URL with format: http://www.youtube.com/watch?feature=player_embedded&v=yyWWXSwtPP0
	 *
	 * @param {String} url
	 * @returns {string}
	 */
	getYouTubeIdFromParam: (url) => {

		if (url === undefined || url === null || !url.trim().length) {
			return null;
		}

		let
			youTubeId = '',
			parts = url.split('?'),
			parameters = parts[1].split('&')
		;

		for (let i = 0, il = parameters.length; i < il; i++) {
			let paramParts = parameters[i].split('=');
			if (paramParts[0] === 'v') {
				youTubeId = paramParts[1];
				break;
			}
		}

		return youTubeId;
	},

	/**
	 * Get ID from URL with formats
	 *  - http://www.youtube.com/v/VIDEO_ID?version=3
	 *  - http://youtu.be/Djd6tPrxc08
	 * @param {String} url
	 * @return {?String}
	 */
	getYouTubeIdFromUrl: (url) => {

		if (url === undefined || url === null || !url.trim().length) {
			return null;
		}

		let parts = url.split('?');
		url = parts[0];
		return url.substring(url.lastIndexOf('/') + 1);
	},

	/**
	 * Inject `no-cookie` element to URL. Only works with format: http://www.youtube.com/v/VIDEO_ID?version=3
	 * @param {String} url
	 * @return {?String}
	 */
	getYouTubeNoCookieUrl: (url) => {
		if (url === undefined || url === null || !url.trim().length || !url.includes('//www.youtube')) {
			return url;
		}

		let parts = url.split('/');
		parts[2] = parts[2].replace('.com', '-nocookie.com');
		return parts.join('/');
	}
};

const YouTubeIframeRenderer = {
	name: 'youtube_iframe',

	options: {
		prefix: 'youtube_iframe',
		/**
		 * Custom configuration for YouTube player
		 *
		 * @see https://developers.google.com/youtube/player_parameters#Parameters
		 * @type {Object}
		 */
		youtube: {
			autoplay: 0,
			controls: 0,
			disablekb: 1,
			end: 0,
			loop: 0,
			modestbranding: 0,
			playsinline: 0,
			rel: 0,
			showinfo: 0,
			start: 0,
			// custom to inject `-nocookie` element in URL
			nocookie: false
		}
	},

	/**
	 * Determine if a specific element type can be played with this render
	 *
	 * @param {String} type
	 * @return {Boolean}
	 */
	canPlayType: (type) => ['video/youtube', 'video/x-youtube'].includes(type),

	/**
	 * Create the player instance and add all native events/methods/properties as possible
	 *
	 * @param {MediaElement} mediaElement Instance of mejs.MediaElement already created
	 * @param {Object} options All the player configuration options passed through constructor
	 * @param {Object[]} mediaFiles List of sources with format: {src: url, type: x/y-z}
	 * @return {Object}
	 */
	create: (mediaElement, options, mediaFiles) => {

		// exposed object
		let youtube = {};
		youtube.options = options;
		youtube.id = mediaElement.id + '_' + options.prefix;
		youtube.mediaElement = mediaElement;

		// API objects
		let
			apiStack = [],
			youTubeApi = null,
			youTubeApiReady = false,
			paused = true,
			ended = false,
			youTubeIframe = null,
			volume = 1,
			readyState = 4,
			i,
			il
		;

		// wrappers for get/set
		let
			props = mejs.html5media.properties,
			assignGettersSetters = (propName) => {

				// add to flash state that we will store

				const capName = `${propName.substring(0, 1).toUpperCase()}${propName.substring(1)}`;

				youtube[`get${capName}`] = () => {
					if (youTubeApi !== null) {
						let value = null;

						// figure out how to get youtube dta here
						switch (propName) {
							case 'currentTime':
								return youTubeApi.getCurrentTime();

							case 'duration':
								return youTubeApi.getDuration();

							case 'volume':
								volume = youTubeApi.getVolume() / 100;
								return volume;

							case 'paused':
								return paused;

							case 'ended':
								return ended;

							case 'muted':
								return youTubeApi.isMuted();

							case 'buffered':
								let percentLoaded = youTubeApi.getVideoLoadedFraction(),
									duration = youTubeApi.getDuration();
								return {
									start: () => {
										return 0;
									},
									end: () => {
										return percentLoaded * duration;
									},
									length: 1
								};
							case 'src':
								return youTubeApi.getVideoUrl();

							case 'readyState':
								return readyState;
						}

						return value;
					} else {
						return null;
					}
				};

				youtube[`set${capName}`] = (value) => {

					if (youTubeApi !== null) {

						// do something
						switch (propName) {

							case 'src':
								let url = typeof value === 'string' ? value : value[0].src,
									videoId = YouTubeApi.getYouTubeId(url);

								if (mediaElement.getAttribute('autoplay')) {
									youTubeApi.loadVideoById(videoId);
								} else {
									youTubeApi.cueVideoById(videoId);
								}
								break;

							case 'currentTime':
								youTubeApi.seekTo(value);
								break;

							case 'muted':
								if (value) {
									youTubeApi.mute();
								} else {
									youTubeApi.unMute();
								}
								setTimeout(() => {
									let event = createEvent('volumechange', youtube);
									mediaElement.dispatchEvent(event);
								}, 50);
								break;

							case 'volume':
								volume = value;
								youTubeApi.setVolume(value * 100);
								setTimeout(() => {
									let event = createEvent('volumechange', youtube);
									mediaElement.dispatchEvent(event);
								}, 50);
								break;
							case 'readyState':
								let event = createEvent('canplay', vimeo);
								mediaElement.dispatchEvent(event);
								break;

							default:
								console.log('youtube ' + youtube.id, propName, 'UNSUPPORTED property');
						}

					} else {
						// store for after "READY" event fires
						apiStack.push({type: 'set', propName: propName, value: value});
					}
				};

			}
		;

		for (i = 0, il = props.length; i < il; i++) {
			assignGettersSetters(props[i]);
		}

		// add wrappers for native methods
		let
			methods = mejs.html5media.methods,
			assignMethods = (methodName) => {

				// run the method on the native HTMLMediaElement
				youtube[methodName] = () => {

					if (youTubeApi !== null) {

						// DO method
						switch (methodName) {
							case 'play':
								return youTubeApi.playVideo();
							case 'pause':
								return youTubeApi.pauseVideo();
							case 'load':
								return null;

						}

					} else {
						apiStack.push({type: 'call', methodName: methodName});
					}
				};

			}
		;

		for (i = 0, il = methods.length; i < il; i++) {
			assignMethods(methods[i]);
		}

		// CREATE YouTube
		let youtubeContainer = document.createElement('div');
		youtubeContainer.id = youtube.id;

		// If `nocookie` feature was enabled, modify original URL
		if (youtube.options.youtube.nocookie) {
			mediaElement.originalNode.setAttribute('src', YouTubeApi.getYouTubeNoCookieUrl(mediaFiles[0].src));
		}

		mediaElement.originalNode.parentNode.insertBefore(youtubeContainer, mediaElement.originalNode);
		mediaElement.originalNode.style.display = 'none';

		let
			isAudio = mediaElement.originalNode.tagName.toLowerCase() === 'audio',
			height = isAudio ? '0' : mediaElement.originalNode.height,
			width = isAudio ? '0' : mediaElement.originalNode.width,
			videoId = YouTubeApi.getYouTubeId(mediaFiles[0].src),
			youtubeSettings = {
				id: youtube.id,
				containerId: youtubeContainer.id,
				videoId: videoId,
				height: height,
				width: width,
				playerVars: Object.assign({
					controls: 0,
					rel: 0,
					disablekb: 1,
					showinfo: 0,
					modestbranding: 0,
					html5: 1,
					playsinline: 0,
					start: 0,
					end: 0
				}, youtube.options.youtube),
				origin: window.location.host,
				events: {
					onReady: (e) => {

						youTubeApiReady = true;
						mediaElement.youTubeApi = youTubeApi = e.target;
						mediaElement.youTubeState = {
							paused: true,
							ended: false
						};

						// do call stack
						if (apiStack.length) {
							for (i = 0, il = apiStack.length; i < il; i++) {

								let stackItem = apiStack[i];

								if (stackItem.type === 'set') {
									let
										propName = stackItem.propName,
										capName = `${propName.substring(0, 1).toUpperCase()}${propName.substring(1)}`
									;

									youtube[`set${capName}`](stackItem.value);
								} else if (stackItem.type === 'call') {
									youtube[stackItem.methodName]();
								}
							}
						}

						// a few more events
						youTubeIframe = youTubeApi.getIframe();

						let
							events = ['mouseover', 'mouseout'],
							assignEvents = (e) => {

								let newEvent = createEvent(e.type, youtube);
								mediaElement.dispatchEvent(newEvent);
							}
						;

						for (let j in events) {
							addEvent(youTubeIframe, events[j], assignEvents);
						}

						// send init events
						let initEvents = ['rendererready', 'loadeddata', 'loadedmetadata', 'canplay'];

						for (i = 0, il = initEvents.length; i < il; i++) {
							let event = createEvent(initEvents[i], youtube);
							mediaElement.dispatchEvent(event);
						}
					},
					onStateChange: (e) => {

						// translate events
						let events = [];

						switch (e.data) {
							case -1: // not started
								events = ['loadedmetadata'];
								paused = true;
								ended = false;
								break;

							case 0: // YT.PlayerState.ENDED
								events = ['ended'];
								paused = false;
								ended = true;

								youtube.stopInterval();
								break;

							case 1:	// YT.PlayerState.PLAYING
								events = ['play', 'playing'];
								paused = false;
								ended = false;

								youtube.startInterval();

								break;

							case 2: // YT.PlayerState.PAUSED
								events = ['paused'];
								paused = true;
								ended = false;

								youtube.stopInterval();
								break;

							case 3: // YT.PlayerState.BUFFERING
								events = ['progress'];
								paused = false;
								ended = false;

								break;
							case 5: // YT.PlayerState.CUED
								events = ['loadeddata', 'loadedmetadata', 'canplay'];
								paused = true;
								ended = false;

								break;
						}

						// send events up
						for (let i = 0, il = events.length; i < il; i++) {
							let event = createEvent(events[i], youtube);
							mediaElement.dispatchEvent(event);
						}

					}
				}
			}
		;

		// The following will prevent that in mobile devices, YouTube is displayed in fullscreen when using audio
		if (isAudio) {
			youtubeSettings.playerVars.playsinline = 1;
		}

		// send it off for async loading and creation
		YouTubeApi.enqueueIframe(youtubeSettings);

		youtube.onEvent = (eventName, player, _youTubeState) => {
			if (_youTubeState !== null && _youTubeState !== undefined) {
				mediaElement.youTubeState = _youTubeState;
			}

		};

		youtube.setSize = (width, height) => {
			if (youTubeApi !== null) {
				youTubeApi.setSize(width, height);
			}
		};
		youtube.hide = () => {
			youtube.stopInterval();
			youtube.pause();
			if (youTubeIframe) {
				youTubeIframe.style.display = 'none';
			}
		};
		youtube.show = () => {
			if (youTubeIframe) {
				youTubeIframe.style.display = '';
			}
		};
		youtube.destroy = () => {
			youTubeApi.destroy();
		};
		youtube.interval = null;

		youtube.startInterval = () => {
			// create timer
			youtube.interval = setInterval(() => {

				let event = createEvent('timeupdate', youtube);
				mediaElement.dispatchEvent(event);

			}, 250);
		};
		youtube.stopInterval = () => {
			if (youtube.interval) {
				clearInterval(youtube.interval);
			}
		};

		return youtube;
	}
};

if (window.postMessage && typeof window.addEventListener) {

	window.onYouTubePlayerAPIReady = () => {
		YouTubeApi.iFrameReady();
	};

	typeChecks.push((url) => {
		url = url.toLowerCase();
		return (url.includes('//www.youtube') || url.includes('//youtu.be')) ? 'video/x-youtube' : null;
	});

	renderer.add(YouTubeIframeRenderer);
}