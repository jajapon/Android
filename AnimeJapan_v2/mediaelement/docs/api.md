# API and Configuration

* [Configuration](#development)
    * [Standalone](#standalone)
    * [MediaElementPlayer](#player)
* [API](#api)
    * [Properties](#properties)
    * [Methods](#methods)
    * [Events](#events)


<a id="configuration"></a>
## Configuration

<a id="standalone"></a>
### Standalone

As a standalone library, _MediaElement.js_ can be configured using the following settings.

Parameter | Type | Default | Description
------ | --------- | ------- | --------
renderers | array | `[]` | List of the renderers to use
fakeNodeName | string | `mediaelementwrapper` | Name of MediaElement container
pluginPath | string | `build/` | Path where Flash shims are located
facebook | object | | Facebook API configuration; all elements listed at https://developers.facebook.com/docs/plugins/embedded-video-player/api#setup are accepted
hls | object | | Native HLS player configuration; all elements listed at https://github.com/dailymotion/hls.js/blob/master/API.md#fine-tuning (except amy callback elements) are accepted
youtube | object | | YouTube iframe player parameters; all elements listed at https://developers.google.com/youtube/player_parameters#Parameters (and a custom `nocookie` parameter to switch to YouTube's no-cookie URL)

<a id="player"></a>
### MediaElementPlayer

Including the above, _MediaElementPlayer_ object allows the following extra configuration elements.

Parameter | Type | Default | Description
------ | --------- | ------- | --------
classPrefix | string | `mejs__` | Class prefix for player elements
poster | string | _(empty)_ | Poster URL that overrides `poster` attribute
showPosterWhenEnded | boolean | `false` | When the video is ended, show the poster
showPosterWhenPaused | boolean | `false` | When the video is paused, show the poster
defaultVideoWidth | number | `480` | Default width if the `<video>` width is not specified
defaultVideoHeight | number | `270` | Default height if the `<video>` height is not specified
videoWidth | number | `-1` | If set, overrides `<video>` width
videoHeight | number | `-1` | If set, overrides `<video>` height
defaultAudioWidth | number | `400` | Default width for audio player if the user doesn't specify
defaultAudioHeight | number | `30` | Default height for audio player if the user doesn't specify
defaultSeekBackwardInterval | function |  | Default amount to move back when back key is pressed. Default callback is represented like: `function(media) {return (media.duration * 0.05);}`
defaultSeekForwardInterval | function |  | Default amount to move forward when forward key is pressed. Default callback is represented like: `function(media) {return (media.duration * 0.05);}`
setDimensions | boolean | `true` | Set dimensions via JS instead of CSS
audioWidth | number | `-1` | Width of audio player
audioHeight | number| `-1` | Height of audio player
startVolume | number | `0.8` | Initial volume when the player starts (overrided by user cookie); represented with `float` values
loop | boolean | `false` | Whether to loop or not media
autoRewind | boolean | `true` | Rewind to beginning when media ends
enableAutosize | boolean | `true` | Resize to media dimensions
timeFormat | string | _(empty)_ | Time format to use. Default: `'mm:ss'`. Supported units: `h`: hour, `m`: minute, `s`: second and `f`: frame count. If use 2 letters, 2 digits will be displayed (`hh:mm:ss`)
alwaysShowHours | boolean | `false` | Force the hour marker (`##:00:00`)
showTimecodeFrameCount | boolean| `false` | Whether to show frame count in timecode (`##:00:00:00`)
framesPerSecond | number | `25` | Used when `showTimecodeFrameCount` is set to `true`
autosizeProgress | boolean | `true` | Automatically calculate the width of the progress bar based on the sizes of other elements
alwaysShowControls | boolean | `false` | Hide controls when playing and mouse is not over the video
hideVideoControlsOnLoad | boolean | `false` | Display the video control when media is loading
hideVideoControlsOnPause | boolean | `false` | Display the video controls when media is paused
clickToPlayPause | boolean | `true` | Enable click video element to toggle play/pause
controlsTimeoutDefault | number | `1500` | Time in ms to hide controls
controlsTimeoutMouseEnter | number | `2500` | Time in ms to trigger the timer when mouse moves
controlsTimeoutMouseLeave | number | `1000` | Time in ms to trigger the timer when mouse leaves
iPadUseNativeControls | boolean | `false` | Force iPad's native controls
iPhoneUseNativeControls | boolean | `false` | Force iPhone's native controls
AndroidUseNativeControls | boolean | `false` | Force Android's native controls
features | array | `[...]` | List of features to show in control bars. Supported features: `playpause`, `current`, `progress`, `fullscreen`, `tracks`, `jumpforward`, `skipback`, `loop`, `markers`, `postroll`, `sourcechooser`, `speed`, `stop`, `time`, `volume`
isVideo | boolean | `true` | Only for dynamic purposes
stretching | string | `auto` | Stretching modes for video player. If `auto` is set, player will try to find the `max-width` and `max-height` CSS styles to turn it into `responsive` mode; otherwise, will set the dimensions specified in the tag (same as setting this option as `none`). The `fill` mode will try to use the available space to make the video fit and, when window is resized, it will crop the dimensions to center it according to the available space.
enableKeyboard | boolean | `true` | Turns keyboard support on and off for this instance
pauseOtherPlayers | boolean | `true` | When focused player starts, it will pause other players
keyActions | array | `[...]` | Keyboard actions to trigger different actions. Accepts array of objects in format: `{keys: [1,2,3...], action: function(player, media) { ... }}`. To see the entire list, please check `/src/js/mediaelementplayer-player.js`
duration | number | `-1` | Start point to detect changes on media time duration
timeAndDurationSeparator | string | `<span> | </span>` | Separator between the current time and the total duration of media being played
hideVolumeOnTouchDevices | boolean | `true` | Touch devices (specially mobile devices) have different way to handle volume, so no need to display it
enableProgressTooltip | boolean | `true` | Enable/disable tooltip that shows time popup in progress bar
audioVolume | string | `horizontal` | Position of volume slider on audio element
videoVolume | string | `vertical` | Position of volume slider on video element
usePluginFullScreen | boolean | `true` | Flag to activate detection of Pointer events when on fullscreen mode 
tracksAriaLive | boolean | `false` | By default, no WAI-ARIA live region - don't make a screen reader speak captions over an audio track.
hideCaptionsButtonWhenEmpty | boolean | `true` | Option to remove the `[cc]` button when no `<track kind="subtitles">` are present
toggleCaptionsButtonWhenOnlyOne | boolean | `false` | If true and we only have one track, change captions to popup
startLanguage | string | _(empty)_ | Automatically turn on a `<track>` element
slidesSelector | string | _(empty)_ | Selector for slides; could be an ID or class represented in jQuery notation (`#id` or `.class`)
tracksText | string | _(empty)_ | Title for Closed Captioning button for WARIA purposes
muteText | string | _(empty)_ | Title for Mute button for WARIA purposes
allyVolumeControlText | string | _(empty)_ | Title for Volume slider for WARIA purposes
fullscreenText | string | _(empty)_ | Title for Fullscreen button for WARIA purposes
playText | string | _(empty)_ | Title for Play/Pause button for WARIA purposes when media is playing
pauseText | string | _(empty)_ | Title for Play/Pause button for WARIA purposes when media is paused


<a id="api"></a>
## API

MediaElementPlayer is a complete audio and video player, but you can also use just the MediaElement object which replaces `<video>` and `<audio>` with a Flash player that mimics the properties, methods, and events of HTML MediaElement API.

<a id="properties"></a>
### Properties
All properties are listed in https://www.w3.org/2010/05/video/mediaevents.html; they can be accessed through an instance of player as described [here](usage.md).

<a id="methods"></a>
### Methods

Method | Description
-------- | ------------
load() | Reload the audio/video element; also, it is used to update the audio/video element after changing the source or other settings
play() | Start playing the audio/video
pause() | Halt (pauses) the currently playing audio or video
stop() | **Only** present to support Flash RTMP streaming in MediaElementPlayer. The equivalent for other scenarios is `pause`
remove() | Destroy the video/audio player instance

**Note:** `canPlayType()` method is used internally and accounts for other types of media to be played (such as HLS, RTMP, etc.); ```addTextTrack()``` is replaced also with more code to manage clsoed captioning and tracks. For that reason, they are not listed.

<a id="events"></a>
### Events

Event | Action(s) executed when...
----- | ----------- 
loadeddata | Media data is loaded
loadedmetadata | Meta data (like dimensions and duration) are loaded
progress | Browser is in the process of getting the media data
timeupdate | The playing position has changed (like when the user fast forwards to a different point in the media)
seeked | The seeking attribute is set to false indicating that seeking has ended
canplay | A file is ready to start playing (when it has buffered enough to begin)
play | The media is ready to start playing
playing	| The media actually has started playing
pause | The media is paused either by the user or programmatically
ended | The media has reach the end (a useful event for messages like "thanks for listening")
volumechange | Volume is changed (including setting the volume to "mute")

For a more comprehensive list of events and more detailed information about them, please check the [Event summary](https://www.w3.org/TR/html5/embedded-content-0.html#mediaevents) page.
________
[Back to Main](../README.md)
