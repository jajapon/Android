'use strict';

import window from 'global/window';
import document from 'global/document';
import mejs from './core/mejs';
import MediaElement from './core/mediaelement';
import i18n from './core/i18n';
import {
	IS_FIREFOX,
	IS_IPAD,
	IS_IPHONE,
	IS_ANDROID,
	IS_IOS,
	HAS_TOUCH,
	HAS_MS_NATIVE_FULLSCREEN,
	HAS_TRUE_NATIVE_FULLSCREEN
} from './utils/constants';
import {splitEvents} from './utils/general';
import {calculateTimeFormat} from './utils/time';
import {isNodeAfter} from './utils/dom';

mejs.mepIndex = 0;

mejs.players = {};

// default player values
export let config = {
	// url to poster (to fix iOS 3.x)
	poster: '',
	// When the video is ended, show the poster.
	showPosterWhenEnded: false,
	// When the video is paused, show the poster.
	showPosterWhenPaused: false,
	// Default if the <video width> is not specified
	defaultVideoWidth: 480,
	// Default if the <video height> is not specified
	defaultVideoHeight: 270,
	// If set, overrides <video width>
	videoWidth: -1,
	// If set, overrides <video height>
	videoHeight: -1,
	// Default if the user doesn't specify
	defaultAudioWidth: 400,
	// Default if the user doesn't specify
	defaultAudioHeight: 40,
	// Default amount to move back when back key is pressed
	defaultSeekBackwardInterval: (media) => media.duration * 0.05,
	// Default amount to move forward when forward key is pressed
	defaultSeekForwardInterval: (media) => media.duration * 0.05,
	// Set dimensions via JS instead of CSS
	setDimensions: true,
	// Width of audio player
	audioWidth: -1,
	// Height of audio player
	audioHeight: -1,
	// Initial volume when the player starts (overridden by user cookie)
	startVolume: 0.8,
	// Useful for <audio> player loops
	loop: false,
	// Rewind to beginning when media ends
	autoRewind: true,
	// Resize to media dimensions
	enableAutosize: true,
	/*
	 * Time format to use. Default: 'mm:ss'
	 * Supported units:
	 *   h: hour
	 *   m: minute
	 *   s: second
	 *   f: frame count
	 * When using 'hh', 'mm', 'ss' or 'ff' we always display 2 digits.
	 * If you use 'h', 'm', 's' or 'f' we display 1 digit if possible.
	 *
	 * Example to display 75 seconds:
	 * Format 'mm:ss': 01:15
	 * Format 'm:ss': 1:15
	 * Format 'm:s': 1:15
	 */
	timeFormat: '',
	// Force the hour marker (##:00:00)
	alwaysShowHours: false,
	// Show framecount in timecode (##:00:00:00)
	showTimecodeFrameCount: false,
	// Used when showTimecodeFrameCount is set to true
	framesPerSecond: 25,
	// Hide controls when playing and mouse is not over the video
	alwaysShowControls: false,
	// Display the video control when media is loading
	hideVideoControlsOnLoad: false,
	// Display the video controls when media is paused
	hideVideoControlsOnPause: false,
	// Enable click video element to toggle play/pause
	clickToPlayPause: true,
	// Time in ms to hide controls
	controlsTimeoutDefault: 1500,
	// Time in ms to trigger the timer when mouse moves
	controlsTimeoutMouseEnter: 2500,
	// Time in ms to trigger the timer when mouse leaves
	controlsTimeoutMouseLeave: 1000,
	// Force iPad's native controls
	iPadUseNativeControls: false,
	// Force iPhone's native controls
	iPhoneUseNativeControls: false,
	// Force Android's native controls
	AndroidUseNativeControls: false,
	// Features to show
	features: ['playpause', 'current', 'progress', 'duration', 'tracks', 'volume', 'fullscreen'],
	// Only for dynamic
	isVideo: true,
	// Stretching modes (auto, fill, responsive, none)
	stretching: 'auto',
	// Prefix class names on elements
	classPrefix: 'mejs__',
	// Turn keyboard support on and off for this instance
	enableKeyboard: true,
	// When this player starts, it will pause other players
	pauseOtherPlayers: true,
	// Array of keyboard actions such as play/pause
	keyActions: [
		{
			keys: [
				32, // SPACE
				179 // GOOGLE play/pause button
			],
			action: (player, media) => {

				if (!IS_FIREFOX) {
					if (media.paused || media.ended) {
						media.play();
					} else {
						media.pause();
					}
				}
			}
		},
		{
			keys: [38], // UP
			action: (player, media) => {

				if (player.container.find(`.${config.classPrefix}volume-button>button`).is(':focus') ||
					player.container.find(`.${config.classPrefix}volume-slider`).is(':focus')) {
					player.container.find(`.${config.classPrefix}volume-slider`).css('display', 'block');
				}
				if (player.isVideo) {
					player.showControls();
					player.startControlsTimer();
				}

				let newVolume = Math.min(media.volume + 0.1, 1);
				media.setVolume(newVolume);
				if (newVolume > 0) {
					media.setMuted(false);
				}

			}
		},
		{
			keys: [40], // DOWN
			action: (player, media) => {

				if (player.container.find(`.${config.classPrefix}volume-button>button`).is(':focus') ||
					player.container.find(`.${config.classPrefix}volume-slider`).is(':focus')) {
					player.container.find(`.${config.classPrefix}volume-slider`).css('display', 'block');
				}

				if (player.isVideo) {
					player.showControls();
					player.startControlsTimer();
				}

				let newVolume = Math.max(media.volume - 0.1, 0);
				media.setVolume(newVolume);

				if (newVolume <= 0.1) {
					media.setMuted(true);
				}

			}
		},
		{
			keys: [
				37, // LEFT
				227 // Google TV rewind
			],
			action: (player, media) => {
				if (!isNaN(media.duration) && media.duration > 0) {
					if (player.isVideo) {
						player.showControls();
						player.startControlsTimer();
					}

					// 5%
					let newTime = Math.max(media.currentTime - player.options.defaultSeekBackwardInterval(media), 0);
					media.setCurrentTime(newTime);
				}
			}
		},
		{
			keys: [
				39, // RIGHT
				228 // Google TV forward
			],
			action: (player, media) => {

				if (!isNaN(media.duration) && media.duration > 0) {
					if (player.isVideo) {
						player.showControls();
						player.startControlsTimer();
					}

					// 5%
					let newTime = Math.min(media.currentTime + player.options.defaultSeekForwardInterval(media), media.duration);
					media.setCurrentTime(newTime);
				}
			}
		},
		{
			keys: [70], // F
			action: (player, media, key, event) => {
				if (!event.ctrlKey) {
					if (typeof player.enterFullScreen !== 'undefined') {
						if (player.isFullScreen) {
							player.exitFullScreen();
						} else {
							player.enterFullScreen();
						}
					}
				}
			}
		},
		{
			keys: [77], // M
			action: (player) => {

				player.container.find(`.${config.classPrefix}volume-slider`).css('display', 'block');
				if (player.isVideo) {
					player.showControls();
					player.startControlsTimer();
				}
				if (player.media.muted) {
					player.setMuted(false);
				} else {
					player.setMuted(true);
				}
			}
		}
	]
};

mejs.MepDefaults = config;

/**
 * Wrap a MediaElement object in player controls
 *
 * @constructor
 * @param {HTMLElement} node
 * @param {Object} o
 * @return {?MediaElementPlayer}
 */
class MediaElementPlayer {

	constructor (node, o) {

		let t = this;

		t.hasFocus = false;

		t.controlsAreVisible = true;

		t.controlsEnabled = true;

		t.controlsTimer = null;

		// enforce object, even without "new" (via John Resig)
		if (!(t instanceof MediaElementPlayer)) {
			return new MediaElementPlayer(node, o);
		}

		// these will be reset after the MediaElement.success fires
		t.$media = t.$node = $(node);
		t.node = t.media = t.$media[0];

		if (!t.node) {
			return;
		}

		// check for existing player
		if (t.node.player !== undefined) {
			return t.node.player;
		}


		// try to get options from data-mejsoptions
		if (o === undefined) {
			o = t.$node.data('mejsoptions');
		}

		// extend default options
		t.options = Object.assign({}, config, o);

		if (!t.options.timeFormat) {
			// Generate the time format according to options
			t.options.timeFormat = 'mm:ss';
			if (t.options.alwaysShowHours) {
				t.options.timeFormat = 'hh:mm:ss';
			}
			if (t.options.showTimecodeFrameCount) {
				t.options.timeFormat += ':ff';
			}
		}

		calculateTimeFormat(0, t.options, t.options.framesPerSecond || 25);

		// unique ID
		t.id = `mep_${mejs.mepIndex++}`;

		// add to player array (for focus events)
		mejs.players[t.id] = t;

		// start up
		let

			meOptions = Object.assign({}, t.options, {
				success: (media, domNode) => {
					t._meReady(media, domNode);
				},
				error: (e) => {
					t._handleError(e);
				}
			}),
			tagName = t.media.tagName.toLowerCase()
			;

		// get video from src or href?
		t.isDynamic = (tagName !== 'audio' && tagName !== 'video');
		t.isVideo = (t.isDynamic) ? t.options.isVideo : (tagName !== 'audio' && t.options.isVideo);

		// use native controls in iPad, iPhone, and Android
		if ((IS_IPAD && t.options.iPadUseNativeControls) || (IS_IPHONE && t.options.iPhoneUseNativeControls)) {

			// add controls and stop
			t.$media.attr('controls', 'controls');

			// override Apple's autoplay override for iPads
			if (IS_IPAD && t.media.getAttribute('autoplay')) {
				t.play();
			}

		} else if (IS_ANDROID && t.options.AndroidUseNativeControls) {

			// leave default player

		} else if (t.isVideo || (!t.isVideo && t.options.features.length)) {

			// DESKTOP: use MediaElementPlayer controls

			// remove native controls
			t.$media.removeAttr('controls');
			let videoPlayerTitle = t.isVideo ? i18n.t('mejs.video-player') : i18n.t('mejs.audio-player');
			// insert description for screen readers
			$(`<span class="${t.options.classPrefix}offscreen">${videoPlayerTitle}</span>`).insertBefore(t.$media);
			// build container
			t.container =
				$(`<div id="${t.id}" class="${t.options.classPrefix}container ${t.options.classPrefix}container-keyboard-inactive"` +
					`tabindex="0" role="application" aria-label="${videoPlayerTitle}">` +
					`<div class="${t.options.classPrefix}inner">` +
					`<div class="${t.options.classPrefix}mediaelement"></div>` +
					`<div class="${t.options.classPrefix}layers"></div>` +
					`<div class="${t.options.classPrefix}controls"></div>` +
					`<div class="${t.options.classPrefix}clear"></div>` +
					`</div>` +
				`</div>`)
				.addClass(t.$media[0].className)
				.insertBefore(t.$media)
				.focus((e) => {
					if (!t.controlsAreVisible && !t.hasFocus && t.controlsEnabled) {
						t.showControls(true);
						// In versions older than IE11, the focus causes the playbar to be displayed
						// if user clicks on the Play/Pause button in the control bar once it attempts
						// to hide it
						if (!HAS_MS_NATIVE_FULLSCREEN) {
							// If e.relatedTarget appears before container, send focus to play button,
							// else send focus to last control button.
							let btnSelector = `.${t.options.classPrefix}playpause-button > button`;

							if (isNodeAfter(e.relatedTarget, t.container[0])) {
								btnSelector = `.${t.options.classPrefix}controls .${t.options.classPrefix}button:last-child > button`;
							}

							let button = t.container.find(btnSelector);
							button.focus();
						}
					}
				});

			// When no elements in controls, hide bar completely
			if (!t.options.features.length) {
				t.container.css('background', 'transparent')
				.find(`.${t.options.classPrefix}controls`)
				.hide();
			}

			if (t.isVideo && t.options.stretching === 'fill' && !t.container.parent(`.${t.options.classPrefix}fill-container`).length) {
				// outer container
				t.outerContainer = t.$media.parent();
				t.container.wrap(`<div class="${t.options.classPrefix}fill-container"/>`);
			}

			// add classes for user and content
			t.container.addClass(
				(IS_ANDROID ? `${t.options.classPrefix}android ` : '') +
				(IS_IOS ? `${t.options.classPrefix}ios ` : '') +
				(IS_IPAD ? `${t.options.classPrefix}ipad ` : '') +
				(IS_IPHONE ? `${t.options.classPrefix}iphone ` : '') +
				(t.isVideo ? `${t.options.classPrefix}video ` : `${t.options.classPrefix}audio `)
			);


			// move the <video/video> tag into the right spot
			t.container.find(`.${t.options.classPrefix}mediaelement`).append(t.$media);

			// needs to be assigned here, after iOS remap
			t.node.player = t;

			// find parts
			t.controls = t.container.find(`.${t.options.classPrefix}controls`);
			t.layers = t.container.find(`.${t.options.classPrefix}layers`);

			// determine the size

			/* size priority:
			 (1) videoWidth (forced),
			 (2) style="width;height;"
			 (3) width attribute,
			 (4) defaultVideoWidth (for unspecified cases)
			 */

			let
				tagType = (t.isVideo ? 'video' : 'audio'),
				capsTagName = tagType.substring(0, 1).toUpperCase() + tagType.substring(1)
				;


			if (t.options[tagType + 'Width'] > 0 || t.options[tagType + 'Width'].toString().indexOf('%') > -1) {
				t.width = t.options[tagType + 'Width'];
			} else if (t.media.style.width !== '' && t.media.style.width !== null) {
				t.width = t.media.style.width;
			} else if (t.media.getAttribute('width')) {
				t.width = t.$media.attr('width');
			} else {
				t.width = t.options['default' + capsTagName + 'Width'];
			}

			if (t.options[tagType + 'Height'] > 0 || t.options[tagType + 'Height'].toString().indexOf('%') > -1) {
				t.height = t.options[tagType + 'Height'];
			} else if (t.media.style.height !== '' && t.media.style.height !== null) {
				t.height = t.media.style.height;
			} else if (t.$media[0].getAttribute('height')) {
				t.height = t.$media.attr('height');
			} else {
				t.height = t.options['default' + capsTagName + 'Height'];
			}

			t.initialAspectRatio = (t.height >= t.width) ? t.width / t.height : t.height / t.width;

			// set the size, while we wait for the plugins to load below
			t.setPlayerSize(t.width, t.height);

			// create MediaElementShim
			meOptions.pluginWidth = t.width;
			meOptions.pluginHeight = t.height;
		}
		// Hide media completely for audio that doesn't have any features
		else if (!t.isVideo && !t.options.features.length) {
			t.$media.hide();
		}

		// create MediaElement shim
		new MediaElement(t.$media[0], meOptions);

		if (t.container !== undefined && t.options.features.length && t.controlsAreVisible && !t.options.hideVideoControlsOnLoad) {
			// controls are shown when loaded
			t.container.trigger('controlsshown');
		}

		return t;
	}

	showControls (doAnimation) {
		let t = this;

		doAnimation = doAnimation === undefined || doAnimation;

		if (t.controlsAreVisible) {
			return;
		}

		if (doAnimation) {
			t.controls
			.removeClass(`${t.options.classPrefix}offscreen`)
			.stop(true, true).fadeIn(200, () => {
				t.controlsAreVisible = true;
				t.container.trigger('controlsshown');
			});

			// any additional controls people might add and want to hide
			t.container.find(`.${t.options.classPrefix}control`)
			.removeClass(`${t.options.classPrefix}offscreen`)
			.stop(true, true).fadeIn(200, () => {
				t.controlsAreVisible = true;
			});

		} else {
			t.controls
			.removeClass(`${t.options.classPrefix}offscreen`)
			.css('display', 'block');

			// any additional controls people might add and want to hide
			t.container.find(`.${t.options.classPrefix}control`)
			.removeClass(`${t.options.classPrefix}offscreen`)
			.css('display', 'block');

			t.controlsAreVisible = true;
			t.container.trigger('controlsshown');
		}

		t.setControlsSize();

	}

	hideControls (doAnimation) {
		let t = this;

		doAnimation = doAnimation === undefined || doAnimation;

		if (!t.controlsAreVisible || t.options.alwaysShowControls || t.keyboardAction ||
			(t.media.paused && t.media.readyState === 4 && ((!t.options.hideVideoControlsOnLoad &&
			t.media.currentTime <= 0) || (!t.options.hideVideoControlsOnPause && t.media.currentTime > 0))) ||
			(t.isVideo && !t.options.hideVideoControlsOnLoad && !t.media.readyState) ||
			t.media.ended) {
			return;
		}

		if (doAnimation) {
			// fade out main controls
			t.controls.stop(true, true).fadeOut(200, function() {
				$(this).addClass(`${t.options.classPrefix}offscreen`).css('display', 'block');

				t.controlsAreVisible = false;
				t.container.trigger('controlshidden');
			});

			// any additional controls people might add and want to hide
			t.container.find(`.${t.options.classPrefix}control`).stop(true, true).fadeOut(200, function() {
				$(this).addClass(`${t.options.classPrefix}offscreen`).css('display', 'block');
			});
		} else {

			// hide main controls
			t.controls
				.addClass(`${t.options.classPrefix}offscreen`)
				.css('display', 'block');

			// hide others
			t.container.find(`.${t.options.classPrefix}control`)
				.addClass(`${t.options.classPrefix}offscreen`)
				.css('display', 'block');

			t.controlsAreVisible = false;
			t.container.trigger('controlshidden');
		}
	}

	startControlsTimer (timeout) {

		let t = this;

		timeout = typeof timeout !== 'undefined' ? timeout : t.options.controlsTimeoutDefault;

		t.killControlsTimer('start');

		t.controlsTimer = setTimeout(() => {
			t.hideControls();
			t.killControlsTimer('hide');
		}, timeout);
	}

	killControlsTimer () {

		let t = this;

		if (t.controlsTimer !== null) {
			clearTimeout(t.controlsTimer);
			delete t.controlsTimer;
			t.controlsTimer = null;
		}
	}

	disableControls () {
		let t = this;

		t.killControlsTimer();
		t.hideControls(false);
		this.controlsEnabled = false;
	}

	enableControls () {
		let t = this;

		t.showControls(false);

		t.controlsEnabled = true;
	}

	/**
	 * Set up all controls and events
	 *
	 * @param media
	 * @param domNode
	 * @private
	 */
	_meReady (media, domNode) {

		let
			t = this,
			autoplayAttr = domNode.getAttribute('autoplay'),
			autoplay = !(autoplayAttr === undefined || autoplayAttr === null || autoplayAttr === 'false'),
			isNative = media.rendererName !== null && media.rendererName.match(/(native|html5)/) !== null
			;

		// make sure it can't create itself again if a plugin reloads
		if (t.created) {
			return;
		}

		t.created = true;
		t.media = media;
		t.domNode = domNode;

		if (!(IS_ANDROID && t.options.AndroidUseNativeControls) && !(IS_IPAD && t.options.iPadUseNativeControls) && !(IS_IPHONE && t.options.iPhoneUseNativeControls)) {

			// In the event that no features are specified for audio,
			// create only MediaElement instance rather than
			// doing all the work to create a full player
			if (!t.isVideo && !t.options.features.length) {

				// force autoplay for HTML5
				if (autoplay && isNative) {
					t.play();
				}


				if (t.options.success) {

					if (typeof t.options.success === 'string') {
						window[t.options.success](t.media, t.domNode, t);
					} else {
						t.options.success(t.media, t.domNode, t);
					}
				}

				return;
			}

			// two built in features
			t.buildposter(t, t.controls, t.layers, t.media);
			t.buildkeyboard(t, t.controls, t.layers, t.media);
			t.buildoverlays(t, t.controls, t.layers, t.media);

			// grab for use by features
			t.findTracks();

			// add user-defined features/controls
			for (let featureIndex in t.options.features) {
				let feature = t.options.features[featureIndex];
				if (t[`build${feature}`]) {
					try {
						t[`build${feature}`](t, t.controls, t.layers, t.media);
					} catch (e) {
						// TODO: report control error
						console.error(`error building ${feature}`, e);
					}
				}
			}

			t.container.trigger('controlsready');

			// reset all layers and controls
			t.setPlayerSize(t.width, t.height);
			t.setControlsSize();

			// controls fade
			if (t.isVideo) {

				if (HAS_TOUCH && !t.options.alwaysShowControls) {

					// for touch devices (iOS, Android)
					// show/hide without animation on touch

					t.$media.on('touchstart', () => {

						// toggle controls
						if (t.controlsAreVisible) {
							t.hideControls(false);
						} else {
							if (t.controlsEnabled) {
								t.showControls(false);
							}
						}
					});

				} else {

					// create callback here since it needs access to current
					// MediaElement object
					t.clickToPlayPauseCallback = () => {

						if (t.options.clickToPlayPause) {
							let
								button = t.$media.closest(`.${t.options.classPrefix}container`)
								.find(`.${t.options.classPrefix}overlay-button`),
								pressed = button.attr('aria-pressed')
								;

							if (t.media.paused && pressed) {
								t.pause();
							} else if (t.media.paused) {
								t.play();
							} else {
								t.pause();
							}

							button.attr('aria-pressed', !(pressed));
						}
					};

					// click to play/pause
					t.media.addEventListener('click', t.clickToPlayPauseCallback, false);
					// t.iframeMouseOver = false;

					// show/hide controls
					t.container
					.on('mouseenter', () => {
						if (t.controlsEnabled) {
							if (!t.options.alwaysShowControls) {
								t.killControlsTimer('enter');
								t.showControls();
								t.startControlsTimer(t.options.controlsTimeoutMouseEnter);
							}
						}
					})
					.on('mousemove', () => {
						if (t.controlsEnabled) {
							if (!t.controlsAreVisible) {
								t.showControls();
							}
							if (!t.options.alwaysShowControls) {
								t.startControlsTimer(t.options.controlsTimeoutMouseEnter);
							}
						}
					})
					.on('mouseleave', () => {
						if (t.controlsEnabled) {
							if (!t.media.paused && !t.options.alwaysShowControls) {
								t.startControlsTimer(t.options.controlsTimeoutMouseLeave);
							}
						}
					});
					// }).on('mouseover', () => {
					// 	t.iframeMouseOver = true;
					// }).on('mouseout', () => {
					// 	t.iframeMouseOver = false;
					// });
					//
					// const monitor = setInterval(function(){
					// 	const elem = document.activeElement;
					// 	if (elem && elem.tagName === 'IFRAME') {
					// 		t.clickToPlayPauseCallback();
					// 		clearInterval(monitor);
					// 	}
					// }, 50);
				}

				if (t.options.hideVideoControlsOnLoad) {
					t.hideControls(false);
				}

				// check for autoplay
				if (autoplay && !t.options.alwaysShowControls) {
					t.hideControls();
				}

				// resizer
				if (t.options.enableAutosize) {
					t.media.addEventListener('loadedmetadata', (e) => {
						// if the <video height> was not set and the options.videoHeight was not set
						// then resize to the real dimensions
						if (t.options.videoHeight <= 0 && !t.domNode.getAttribute('height') && !isNaN(e.target.videoHeight)) {
							t.setPlayerSize(e.target.videoWidth, e.target.videoHeight);
							t.setControlsSize();
							t.media.setSize(e.target.videoWidth, e.target.videoHeight);
						}
					}, false);
				}
			}

			// EVENTS

			// FOCUS: when a video starts playing, it takes focus from other players (possibly pausing them)
			t.media.addEventListener('play', () => {
				t.hasFocus = true;

				// go through all other players
				for (let playerIndex in mejs.players) {
					let p = mejs.players[playerIndex];
					if (p.id !== t.id && t.options.pauseOtherPlayers && !p.paused && !p.ended) {
						p.pause();
						p.hasFocus = false;
					}
				}

			}, false);

			// ended for all
			t.media.addEventListener('ended', () => {
				if (t.options.autoRewind) {
					try {
						t.media.setCurrentTime(0);
						// Fixing an Android stock browser bug, where "seeked" isn't fired correctly after ending the video and jumping to the beginning
						window.setTimeout(() => {
							$(t.container)
							.find(`.${t.options.classPrefix}overlay-loading`)
							.parent().hide();
						}, 20);
					} catch (exp) {

					}
				}

				if (typeof t.media.stop === 'function') {
					t.media.stop();
				} else {
					t.media.pause();
				}

				if (t.setProgressRail) {
					t.setProgressRail();
				}
				if (t.setCurrentRail) {
					t.setCurrentRail();
				}

				if (t.options.loop) {
					t.play();
				} else if (!t.options.alwaysShowControls && t.controlsEnabled) {
					t.showControls();
				}
			}, false);

			// resize on the first play
			t.media.addEventListener('loadedmetadata', () => {

				calculateTimeFormat(t.duration, t.options, t.options.framesPerSecond || 25);

				if (t.updateDuration) {
					t.updateDuration();
				}
				if (t.updateCurrent) {
					t.updateCurrent();
				}

				if (!t.isFullScreen) {
					t.setPlayerSize(t.width, t.height);
					t.setControlsSize();
				}
			}, false);

			// Only change the time format when necessary
			let duration = null;
			t.media.addEventListener('timeupdate', () => {
				if (duration !== t.media.duration) {
					duration = t.media.duration;
					calculateTimeFormat(duration, t.options, t.options.framesPerSecond || 25);

					// make sure to fill in and resize the controls (e.g., 00:00 => 01:13:15
					if (t.updateDuration) {
						t.updateDuration();
					}
					if (t.updateCurrent) {
						t.updateCurrent();
					}
					t.setControlsSize();
				}
			}, false);

			t.container.focusout((e) => {
				if (e.relatedTarget) { //FF is working on supporting focusout https://bugzilla.mozilla.org/show_bug.cgi?id=687787
					let $target = $(e.relatedTarget);
					if (t.keyboardAction && $target.parents(`.${t.options.classPrefix}container`).length === 0) {
						t.keyboardAction = false;
						if (t.isVideo && !t.options.alwaysShowControls) {
							t.hideControls(true);
						}

					}
				}
			});

			// webkit has trouble doing this without a delay
			setTimeout(() => {
				t.setPlayerSize(t.width, t.height);
				t.setControlsSize();
			}, 50);

			// adjust controls whenever window sizes (used to be in fullscreen only)
			t.globalBind('resize', () => {

				// don't resize for fullscreen mode
				if (!(t.isFullScreen || (HAS_TRUE_NATIVE_FULLSCREEN && document.webkitIsFullScreen))) {
					t.setPlayerSize(t.width, t.height);
				}

				// always adjust controls
				t.setControlsSize();
			});

			// Disable focus outline to improve look-and-feel for regular users
			t.globalBind('click', (e) => {
				if ($(e.target).is(`.${t.options.classPrefix}container`)) {
					$(e.target).addClass(`${t.options.classPrefix}container-keyboard-inactive`);
				} else if ($(e.target).closest(`.${t.options.classPrefix}container`).length) {
					$(e.target).closest(`.${t.options.classPrefix}container`)
					.addClass(`${t.options.classPrefix}container-keyboard-inactive`);
				}
			});

			// Enable focus outline for Accessibility purposes
			t.globalBind('keydown', (e) => {
				if ($(e.target).is(`.${t.options.classPrefix}container`)) {
					$(e.target).removeClass(`${t.options.classPrefix}container-keyboard-inactive`);
				} else if ($(e.target).closest(`.${t.options.classPrefix}container`).length) {
					$(e.target).closest(`.${t.options.classPrefix}container`)
					.removeClass(`${t.options.classPrefix}container-keyboard-inactive`);
				}
			});

			// This is a work-around for a bug in the YouTube iFrame player, which means
			//	we can't use the play() API for the initial playback on iOS or Android;
			//	user has to start playback directly by tapping on the iFrame.
			if (t.media.rendererName !== null && t.media.rendererName.match(/youtube/) && (IS_IOS || IS_ANDROID)) {
				t.container.find(`.${t.options.classPrefix}overlay-play`).hide();
				t.container.find(`.${t.options.classPrefix}poster`).hide();
			}
		}

		// force autoplay for HTML5
		if (autoplay && isNative) {
			t.play();
		}

		if (t.options.success) {

			if (typeof t.options.success === 'string') {
				window[t.options.success](t.media, t.domNode, t);
			} else {
				t.options.success(t.media, t.domNode, t);
			}
		}
	}

	/**
	 *
	 * @param {Event} e
	 * @private
	 */
	_handleError (e) {
		let t = this;

		if (t.controls) {
			t.disableControls();
		}

		// Tell user that the file cannot be played
		if (t.options.error) {
			t.options.error(e);
		}
	}

	setPlayerSize (width, height) {
		let t = this;

		if (!t.options.setDimensions) {
			return false;
		}

		if (typeof width !== 'undefined') {
			t.width = width;
		}

		if (typeof height !== 'undefined') {
			t.height = height;
		}

		if (typeof FB !== 'undefined' && t.isVideo) {
			FB.Event.subscribe('xfbml.ready', () => {
				let target = $(t.media).children('.fb-video');

				t.width = target.width();
				t.height = target.height();
				t.setDimensions(t.width, t.height);
				return false;
			});

			let target = $(t.media).children('.fb-video');

			if (target.length) {
				t.width = target.width();
				t.height = target.height();
			}
		}

		// check stretching modes
		switch (t.options.stretching) {
			case 'fill':
				// The 'fill' effect only makes sense on video; for audio we will set the dimensions
				if (t.isVideo) {
					t.setFillMode();
				} else {
					t.setDimensions(t.width, t.height);
				}
				break;
			case 'responsive':
				t.setResponsiveMode();
				break;
			case 'none':
				t.setDimensions(t.width, t.height);
				break;
			// This is the 'auto' mode
			default:
				if (t.hasFluidMode() === true) {
					t.setResponsiveMode();
				} else {
					t.setDimensions(t.width, t.height);
				}
				break;
		}
	}

	hasFluidMode () {
		let t = this;

		// detect 100% mode - use currentStyle for IE since css() doesn't return percentages
		return (t.height.toString().includes('%') || (t.$node.css('max-width') !== 'none' && t.$node.css('max-width') !== t.width) || (t.$node[0].currentStyle && t.$node[0].currentStyle.maxWidth === '100%'));
	}

	setResponsiveMode () {
		let t = this;

		// do we have the native dimensions yet?
		let nativeWidth = (() => {
			if (t.isVideo) {
				if (t.media.videoWidth && t.media.videoWidth > 0) {
					return t.media.videoWidth;
				} else if (t.media.getAttribute('width')) {
					return t.media.getAttribute('width');
				} else {
					return t.options.defaultVideoWidth;
				}
			} else {
				return t.options.defaultAudioWidth;
			}
		})();

		let nativeHeight = (() => {
			if (t.isVideo) {
				if (t.media.videoHeight && t.media.videoHeight > 0) {
					return t.media.videoHeight;
				} else if (t.media.getAttribute('height')) {
					return t.media.getAttribute('height');
				} else {
					return t.options.defaultVideoHeight;
				}
			} else {
				return t.options.defaultAudioHeight;
			}
		})();

		// Use media aspect ratio if received; otherwise, the initially stored initial aspect ratio
		let
			aspectRatio = (() => {
				let ratio = 1;
				if (!t.isVideo) {
					return ratio;
				}

				if (t.media.videoWidth && t.media.videoWidth > 0 && t.media.videoHeight && t.media.videoHeight > 0) {
					ratio = (t.height >= t.width) ? t.media.videoWidth / t.media.videoHeight : t.media.videoHeight / t.media.videoWidth;
				} else {
					ratio = t.initialAspectRatio;
				}

				if (isNaN(ratio) || ratio < 0.01 || ratio > 100) {
					ratio = 1;
				}

				return ratio;
			})(),
			parentWidth = t.container.parent().closest(':visible').width(),
			parentHeight = t.container.parent().closest(':visible').height(),
			newHeight;

		if (t.isVideo) {
			// Responsive video is based on width: 100% and height: 100%
			if (t.height === '100%') {
				newHeight = parseInt(parentWidth * nativeHeight / nativeWidth, 10);
			} else {
				newHeight = t.height >= t.width ? parseInt(parentWidth / aspectRatio, 10) : parseInt(parentWidth * aspectRatio, 10);
			}
		} else {
			newHeight = nativeHeight;
		}

		// If we were unable to compute newHeight, get the container height instead
		if (isNaN(newHeight)) {
			newHeight = parentHeight;
		}

		if (t.container.parent().length > 0 && t.container.parent()[0].tagName.toLowerCase() === 'body') { // && t.container.siblings().count == 0) {
			parentWidth = $(window).width();
			newHeight = $(window).height();
		}

		if (newHeight && parentWidth) {

			// set outer container size
			t.container
			.width(parentWidth)
			.height(newHeight);

			// set native <video> or <audio> and shims
			t.$media
			.width('100%')
			.height('100%');

			// if shim is ready, send the size to the embedded plugin
			if (t.isVideo) {
				if (t.media.setSize) {
					t.media.setSize(parentWidth, newHeight);
				}
			}

			// set the layers
			t.layers.children(`.${t.options.classPrefix}layer`)
			.width('100%')
			.height('100%');
		}
	}

	setFillMode () {
		let t = this,
			parent = t.outerContainer;

		// Remove the responsive attributes in the event they are there
		if (t.$node.css('height') !== 'none' && t.$node.css('height') !== t.height) {
			t.$node.css('height', '');
		}
		if (t.$node.css('max-width') !== 'none' && t.$node.css('max-width') !== t.width) {
			t.$node.css('max-width', '');
		}

		if (t.$node.css('max-height') !== 'none' && t.$node.css('max-height') !== t.height) {
			t.$node.css('max-height', '');
		}

		if (t.$node[0].currentStyle) {
			if (t.$node[0].currentStyle.height === '100%') {
				t.$node[0].currentStyle.height = '';
			}
			if (t.$node[0].currentStyle.maxWidth === '100%') {
				t.$node[0].currentStyle.maxWidth = '';
			}
			if (t.$node[0].currentStyle.maxHeight === '100%') {
				t.$node[0].currentStyle.maxHeight = '';
			}
		}

		if (!parent.width()) {
			parent.height(t.$media.width());
		}

		if (!parent.height()) {
			parent.height(t.$media.height());
		}

		let parentWidth = parent.width(),
			parentHeight = parent.height();

		t.setDimensions('100%', '100%');

		// This prevents an issue when displaying poster
		t.container.find(`.${t.options.classPrefix}poster img`).css('display', 'block');

		// calculate new width and height
		let
			targetElement = t.container.find('object, embed, iframe, video'),
			initHeight = t.height,
			initWidth = t.width,
			// scale to the target width
			scaleX1 = parentWidth,
			scaleY1 = (initHeight * parentWidth) / initWidth,
			// scale to the target height
			scaleX2 = (initWidth * parentHeight) / initHeight,
			scaleY2 = parentHeight,
			// now figure out which one we should use
			bScaleOnWidth = scaleX2 > parentWidth === false,
			finalWidth = bScaleOnWidth ? Math.floor(scaleX1) : Math.floor(scaleX2),
			finalHeight = bScaleOnWidth ? Math.floor(scaleY1) : Math.floor(scaleY2);

		if (bScaleOnWidth) {
			targetElement.height(finalHeight).width(parentWidth);
			if (t.media.setSize) {
				t.media.setSize(parentWidth, finalHeight);
			}
		} else {
			targetElement.height(parentHeight).width(finalWidth);
			if (t.media.setSize) {
				t.media.setSize(finalWidth, parentHeight);
			}
		}

		targetElement.css({
			'margin-left': Math.floor((parentWidth - finalWidth) / 2),
			'margin-top': 0
		});
	}

	setDimensions (width, height) {
		let t = this;

		t.container
		.width(width)
		.height(height);

		t.layers.children(`.${t.options.classPrefix}layer`)
		.width(width)
		.height(height);
	}

	setControlsSize () {
		let t = this;

		// skip calculation if hidden
		if (!t.container.is(':visible') || !t.rail || !t.rail.length || !t.rail.is(':visible')) {
			return;
		}

		let
			railMargin = parseFloat(t.rail.css('margin-left')) + parseFloat(t.rail.css('margin-right')),
			totalMargin = parseFloat(t.total.css('margin-left')) + parseFloat(t.total.css('margin-right')) || 0,
			siblingsWidth = 0
		;

		t.rail.siblings().each((index, object) => {
			siblingsWidth += parseFloat($(object).outerWidth(true));
		});

		siblingsWidth += totalMargin + railMargin + 1;

		// Substract the width of the feature siblings from time rail
		t.rail.width(t.controls.width() - siblingsWidth);

		t.container.trigger('controlsresize');
	}

	resetSize () {
		let t = this;
		// webkit has trouble doing this without a delay
		setTimeout(() => {
			t.setPlayerSize(t.width, t.height);
			t.setControlsSize();
		}, 50);
	}

	setPoster (url) {
		let t = this,
			posterDiv = t.container.find(`.${t.options.classPrefix}poster`),
			posterImg = posterDiv.find('img');

		if (posterImg.length === 0) {
			posterImg = $(`<img class="${t.options.classPrefix}poster-img" width="100%" height="100%" alt="" />`)
			.appendTo(posterDiv);
		}

		posterImg.attr('src', url);
		posterDiv.css({'background-image': `url("${url}")`});
	}

	changeSkin (className) {
		let t = this;

		t.container[0].className = `${t.options.classPrefix}container ${className}`;
		t.setPlayerSize(t.width, t.height);
		t.setControlsSize();
	}

	globalBind (events, data, callback) {
		let
			t = this,
			doc = t.node ? t.node.ownerDocument : document
		;

		events = splitEvents(events, t.id);
		if (events.d) {
			$(doc).on(events.d, data, callback);
		}
		if (events.w) {
			$(window).on(events.w, data, callback);
		}
	}

	globalUnbind (events, callback) {

		let
			t = this,
			doc = t.node ? t.node.ownerDocument : document
		;

		events = splitEvents(events, t.id);
		if (events.d) {
			$(doc).off(events.d, callback);
		}
		if (events.w) {
			$(window).off(events.w, callback);
		}
	}

	buildposter (player, controls, layers, media) {

		let
			t = this,
			poster = $(`<div class="${t.options.classPrefix}poster ${t.options.classPrefix}layer"></div>`).appendTo(layers),
			posterUrl = player.$media.attr('poster')
		;

		// priority goes to option (this is useful if you need to support iOS 3.x (iOS completely fails with poster)
		if (player.options.poster !== '') {
			posterUrl = player.options.poster;
		}

		// second, try the real poster
		if (posterUrl) {
			t.setPoster(posterUrl);
		} else {
			poster.hide();
		}

		media.addEventListener('play', () => {
			poster.hide();
		}, false);

		if (player.options.showPosterWhenEnded && player.options.autoRewind) {
			media.addEventListener('ended', () => {
				poster.show();
			}, false);
		}

		if (player.options.showPosterWhenPaused) {
			media.addEventListener('pause', () => {
				// To avoid displaying the poster when video ended, since it
				// triggers a pause event as well
				if (!media.ended) {
					poster.show();
				}
			}, false);
		}
	}

	buildoverlays (player, controls, layers, media) {

		if (!player.isVideo) {
			return;
		}

		let
			t = this,
			loading =
				$(`<div class="${t.options.classPrefix}overlay ${t.options.classPrefix}layer">` +
					`<div class="${t.options.classPrefix}overlay-loading">` +
						`<span class="${t.options.classPrefix}overlay-loading-bg-img"></span>` +
					`</div>` +
				`</div>`)
				.hide() // start out hidden
				.appendTo(layers),
			error =
				$(`<div class="${t.options.classPrefix}overlay ${t.options.classPrefix}layer">` +
					`<div class="${t.options.classPrefix}overlay-error"></div>` +
				`</div>`)
				.hide() // start out hidden
				.appendTo(layers),
			// this needs to come last so it's on top
			bigPlay =
				$(`<div class="${t.options.classPrefix}overlay ${t.options.classPrefix}layer ${t.options.classPrefix}overlay-play">` +
					`<div class="${t.options.classPrefix}overlay-button" role="button" ` +
						`aria-label="${i18n.t('mejs.play')}" aria-pressed="false">` +
					`</div>` +
				`</div>`)
				.appendTo(layers)
				.on('click', () => {
					// Removed 'touchstart' due issues on Samsung Android devices where a tap on bigPlay
					// started and immediately stopped the video
					if (t.options.clickToPlayPause) {

						let
							button = t.$media.closest(`.${t.options.classPrefix}container`)
							.find(`.${t.options.classPrefix}overlay-button`),
							pressed = button.attr('aria-pressed')
						;

						if (media.paused) {
							media.play();
						} else {
							media.pause();
						}

						button.attr('aria-pressed', !!pressed);
					}
				});

		// if (t.options.supportVR || (t.media.rendererName !== null && t.media.rendererName.match(/(youtube|facebook)/))) {
		if (t.media.rendererName !== null && t.media.rendererName.match(/(youtube|facebook)/)) {
			bigPlay.hide();
		}

		// show/hide big play button
		media.addEventListener('play', () => {
			bigPlay.hide();
			loading.hide();
			controls.find(`.${t.options.classPrefix}time-buffering`).hide();
			error.hide();
		}, false);

		media.addEventListener('playing', () => {
			bigPlay.hide();
			loading.hide();
			controls.find(`.${t.options.classPrefix}time-buffering`).hide();
			error.hide();
		}, false);

		media.addEventListener('seeking', () => {
			loading.show();
			controls.find(`.${t.options.classPrefix}time-buffering`).show();
		}, false);

		media.addEventListener('seeked', () => {
			loading.hide();
			controls.find(`.${t.options.classPrefix}time-buffering`).hide();
		}, false);

		media.addEventListener('pause', () => {
			bigPlay.show();
		}, false);

		media.addEventListener('waiting', () => {
			loading.show();
			controls.find(`.${t.options.classPrefix}time-buffering`).show();
		}, false);


		// show/hide loading
		media.addEventListener('loadeddata', () => {
			// for some reason Chrome is firing this event
			//if (mejs.MediaFeatures.isChrome && media.getAttribute && media.getAttribute('preload') === 'none')
			//	return;

			loading.show();
			controls.find(`.${t.options.classPrefix}time-buffering`).show();
			// Firing the 'canplay' event after a timeout which isn't getting fired on some Android 4.1 devices
			// (https://github.com/johndyer/mediaelement/issues/1305)
			if (IS_ANDROID) {
				media.canplayTimeout = window.setTimeout(
					() => {
						if (document.createEvent) {
							let evt = document.createEvent('HTMLEvents');
							evt.initEvent('canplay', true, true);
							return media.dispatchEvent(evt);
						}
					}, 300
				);
			}
		}, false);
		media.addEventListener('canplay', () => {
			loading.hide();
			controls.find(`.${t.options.classPrefix}time-buffering`).hide();
			// Clear timeout inside 'loadeddata' to prevent 'canplay' from firing twice
			clearTimeout(media.canplayTimeout);
		}, false);

		// error handling
		media.addEventListener('error', (e) => {
			t._handleError(e);
			loading.hide();
			bigPlay.hide();
			error.show();
			error.find(`.${t.options.classPrefix}overlay-error`).html(e.message);
		}, false);

		media.addEventListener('keydown', (e) => {
			t.onkeydown(player, media, e);
		}, false);
	}

	buildkeyboard (player, controls, layers, media) {

		let t = this;

		t.container.keydown(() => {
			t.keyboardAction = true;
		});

		// listen for key presses
		t.globalBind('keydown', (event) => {
			let $container = $(event.target).closest(`.${t.options.classPrefix}container`);
			player.hasFocus = $container.length !== 0 &&
				$container.attr('id') === player.$media.closest(`.${t.options.classPrefix}container`).attr('id');
			return t.onkeydown(player, media, event);
		});


		// check if someone clicked outside a player region, then kill its focus
		t.globalBind('click', (event) => {
			player.hasFocus = $(event.target).closest(`.${t.options.classPrefix}container`).length !== 0;
		});

	}

	onkeydown (player, media, e) {

		if (player.hasFocus && player.options.enableKeyboard) {
			// find a matching key
			for (let i = 0, il = player.options.keyActions.length; i < il; i++) {
				let keyAction = player.options.keyActions[i];

				for (let j = 0, jl = keyAction.keys.length; j < jl; j++) {
					if (e.keyCode === keyAction.keys[j]) {
						keyAction.action(player, media, e.keyCode, e);
						return false;
					}
				}
			}
		}

		return true;
	}

	play () {
		let t = this;

		// only load if the current time is 0 to ensure proper playing
		if (t.media.getCurrentTime() <= 0) {
			t.load();
		}
		t.media.play();
	}

	pause () {
		try {
			this.media.pause();
		} catch (e) {
		}
	}

	load () {
		let t = this;

		if (!t.isLoaded) {
			t.media.load();
		}

		t.isLoaded = true;
	}

	setMuted (muted) {
		this.media.setMuted(muted);
	}

	setCurrentTime (time) {
		this.media.setCurrentTime(time);
	}

	getCurrentTime () {
		return this.media.currentTime;
	}

	setVolume (volume) {
		this.media.setVolume(volume);
	}

	getVolume () {
		return this.media.volume;
	}

	setSrc (src) {
		this.media.setSrc(src);
	}

	remove () {

		let
			t = this,
			rendererName = t.media.rendererName
		;

		// invoke features cleanup
		for (let featureIndex in t.options.features) {
			let feature = t.options.features[featureIndex];
			if (t[`clean${feature}`]) {
				try {
					t[`clean${feature}`](t);
				} catch (e) {
					// @todo: report control error
					console.error(`error cleaning ${feature}`, e);
				}
			}
		}

		// reset dimensions
		t.$node.css({
			width: t.$node.attr('width') || 'auto',
			height: t.$node.attr('height') || 'auto'
		});

		// grab video and put it back in place
		if (!t.isDynamic) {
			t.$media.prop('controls', true);
			// detach events from the video
			// @todo: detach event listeners better than this; also detach ONLY the events attached by this plugin!
			t.$node.attr('id', t.$node.attr('id').replace(`_${rendererName}`, ''));
			t.$node.clone().insertBefore(t.container).show();
			t.$node.remove();
		} else {
			t.$node.insertBefore(t.container);
		}

		if (typeof t.media.destroy === 'function') {
			t.media.destroy();
		}

		t.media.remove();


		// Remove the player from the mejs.players object so that pauseOtherPlayers doesn't blow up when trying to
		// pause a non existent Flash API.
		delete mejs.players[t.id];

		if (typeof t.container === 'object') {
			t.container.prev(`.${t.options.classPrefix}offscreen`).remove();
			t.container.remove();
		}
		t.globalUnbind();
		delete t.node.player;
	}
}

window.MediaElementPlayer = MediaElementPlayer;

export default MediaElementPlayer;

// turn into plugin
(($) => {

	if (typeof $ !== 'undefined') {
		$.fn.mediaelementplayer = function (options) {
			if (options === false) {
				this.each(function () {
					let player = $(this).data('mediaelementplayer');
					if (player) {
						player.remove();
					}
					$(this).removeData('mediaelementplayer');
				});
			}
			else {
				this.each(function () {
					$(this).data('mediaelementplayer', new MediaElementPlayer(this, options));
				});
			}
			return this;
		};

		$(document).ready(() => {
			// auto enable using JSON attribute
			$(`.${config.classPrefix}player`).mediaelementplayer();
		});
	}

})(mejs.$);