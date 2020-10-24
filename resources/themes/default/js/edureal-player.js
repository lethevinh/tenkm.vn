console.log(' Edureal Player Init');
import videojs from 'video.js';

require('videojs-playlist');
require('videojs-playlist-ui');
require('videojs-playbackrate-adjuster');

let Button = videojs.getComponent('Button');
const dom = videojs.dom || videojs;
const registerPlugin = videojs.registerPlugin || videojs.plugin;
const Component = videojs.getComponent('Component');

// Plugins -------------
/* PrevButton */
let PrevButton = videojs.extend(Button, {
    constructor: function () {
        Button.apply(this, arguments);
        this.addClass('icon-angle-left');
        this.controlText("Previous");
    },
    handleClick: function () {
        let coursePlayer = this.player();
        // console.log('click');
        coursePlayer.playlist.previous();
        coursePlayer.play();
    }
});
videojs.registerComponent('PrevButton', PrevButton);
/* NextButton */
let NextButton = videojs.extend(Button, {
    constructor: function () {
        Button.apply(this, arguments);
        this.addClass('icon-angle-right');
        this.controlText("Next");
    },
    handleClick: function () {
        // console.log('click');
        let coursePlayer = this.player();
        coursePlayer.playlist.next();
        coursePlayer.play();
    }
});
videojs.registerComponent('NextButton', NextButton);

// Components

/* Playlist */
// Array#indexOf analog for IE8
const indexOf = function (array, target) {
    for (let i = 0, length = array.length; i < length; i++) {
        if (array[i] === target) {
            return i;
        }
    }
    return -1;
};
// see https://github.com/Modernizr/Modernizr/blob/master/feature-detects/css/pointerevents.js
const supportsCssPointerEvents = (() => {
    const element = document.createElement('x');

    element.style.cssText = 'pointer-events:auto';
    return element.style.pointerEvents === 'auto';
})();
const defaults = {
    className: 'vjs-playlist',
    playOnSelect: false,
    supportsCssPointerEvents
};
/**
 * Returns a boolean indicating whether an element has child elements.
 *
 * Note that this is distinct from whether it has child _nodes_.
 *
 * @param  {HTMLElement} el
 *         A DOM element.
 *
 * @return {boolean}
 *         Whether the element has child elements.
 */
const hasChildEls = (el) => {
    for (let i = 0; i < el.childNodes.length; i++) {
        if (dom.isEl(el.childNodes[i])) {
            return true;
        }
    }
    return false;
};

/**
 * Finds the first empty root element.
 *
 * @param  {string} className
 *         An HTML class name to search for.
 *
 * @return {HTMLElement}
 *         A DOM element to use as the root for a playlist.
 */
const findRoot = (className) => {
    const all = document.querySelectorAll('.' + className);
    let el;

    for (let i = 0; i < all.length; i++) {
        if (!hasChildEls(all[i])) {
            el = all[i];
            break;
        }
    }

    return el;
};

/**
 * Initialize the plugin on a player.
 *
 * @param  {Object} [options]
 *         An options object.
 *
 * @param  {HTMLElement} [options.el]
 *         A DOM element to use as a root node for the playlist.
 *
 * @param  {string} [options.className]
 *         An HTML class name to use to find a root node for the playlist.
 *
 * @param  {boolean} [options.playOnSelect = false]
 *         If true, will attempt to begin playback upon selecting a new
 *         playlist item in the UI.
 */

class PlaylistEdurealMenu extends Component {

    constructor(player, options) {

        if (!player.playlist) {
            throw new Error('videojs-playlist is required for the playlist component');
        }

        super(player, options);

        this.items = [];

        if (options.horizontal) {
            this.addClass('vjs-playlist-horizontal');
        } else {
            this.addClass('vjs-playlist-vertical');
        }

        if (options.supportsCssPointerEvents) {
            this.addClass('vjs-csspointerevents');
        }

        this.createPlaylist_();

        if (!videojs.browser.TOUCH_ENABLED) {
            this.addClass('vjs-mouse');
        }

        this.on(player, ['loadstart', 'playlistchange', 'playlistsorted'], (event) => {
            this.update();
        });

        // Keep track of whether an ad is playing so that the menu
        // appearance can be adapted appropriately
        this.on(player, 'adstart', () => {
            this.addClass('vjs-ad-playing');
        });

        this.on(player, 'adend', () => {
            this.removeClass('vjs-ad-playing');
        });

        this.on('dispose', () => {
            this.empty_();
            player.playlistMenu = null;
        });

        this.on(player, 'dispose', () => {
            this.dispose();
        });
    }

    createEl() {
        return dom.createEl('div', {className: this.options_.className});
    }

    empty_() {
        if (this.items && this.items.length) {
            // this.items.forEach(i => i.dispose());
            this.items.length = 0;
        }
    }

    createPlaylist_() {
        const playlist = this.player_.playlist() || [];
        let list = this.el_.querySelector('.vjs-playlist-item-list');
        let overlay = this.el_.querySelector('.vjs-playlist-ad-overlay');

        if (!list) {
            list = document.createElement('ol');
            list.className = 'vjs-playlist-item-list';
            this.el_.appendChild(list);
        }

        this.empty_();
        for (const section of this.options_.sections) {
            let lectureEl = this.createLecture(section);
            for (const lecture of section.lectures) {
                for (const resource of lecture.resources) {
                    let media = resource.media;
                    if (media && media.ext === 'video') {
                        let video = playlist.find(i => i.id === lecture.id + '_' + resource.id + '_' + media.id);
                        let curriculumEl = this.createCurriculum(resource, video);
                        lectureEl.find('ul').append(curriculumEl);
                        this.items.push(video.id);
                    } else {
                        let curriculumEl = this.createCurriculum(resource, false);
                        lectureEl.find('ul').append(curriculumEl);
                    }
                }
            }
            list.appendChild(lectureEl.get(0))
        }

        // select the current playlist item
        const selectedIndex = this.player_.playlist.currentItem();
        if (this.items.length && selectedIndex >= 0) {
            $('[data-video-id="' + this.items[selectedIndex] + ']').addClass('vjs-selected');
        }
    }

    createLecture(lecture) {
        return $('<li class="section--section--BukKG" data-purpose="section-panel-2" aria-expanded="true">' +
            '    <div role="button" tabindex="0" class="section--section-heading--2k6aW" data-purpose="section-heading">' +
            '        <div class="section--title--eCwjX" data-purpose="section-label">' +
            '            <span width="0">' +
            '                <span>' +
            '                    <span>' +
            lecture.title +
            '                    </span>' +
            '                </span>' +
            '                <span style="position: fixed; visibility: hidden; top: 0px; left: 0px;">…</span>' +
            '            </span>' +
            '        </div>' +
            '        <i data-toggle="collapse" href="#collapseExample_' + lecture.id + '" role="button" aria-expanded="true" aria-controls="collapseExample" class="section--section-chevron--tJ4mD udi ion-arrow-down-b"></i>' +
            '        <div class="font-text-xs">' +
            '            <span data-purpose="section-duration" class="ml-space-xxs">19 min</span>' +
            '        </div>' +
            '    </div>' +
            '    <ul class="section--section-list--1VLOz collapse" id="collapseExample_' + lecture.id + '">' +
            '    </ul>' +
            '</li>');
    }

    createCurriculum(resource, video) {
        let classActive = video ? 'active' : 'de-active';
        let curriculumEl = $('<li data-video-id="' + video.id + '" aria-current="false" class="curriculum-item-link--curriculum-item ' + classActive + '">\n' +
            '            <div data-purpose="curriculum-item-2-0" class="item-link item-link--common--RP3fp item-link--default-theme--YqsPR" aria-label="7. The FIRST circle" tabindex="0" role="link">\n' +
            '                <label class="curriculum-item-link--progress-toggle--1CMcg checkbox-inline" title="">\n' +
            '                    <input data-purpose="progress-toggle-button" aria-label="Lecture completed" type="checkbox" checked="">\n' +
            '                    <span class="toggle-control-label checkbox-label"></span>\n' +
            '                </label>\n' +
            '                <div class="curriculum-item-link--item-container--1ptOz">\n' +
            '                    <div class="curriculum-item-link--title">\n' +
            '                        <span width="0">\n' +
            '                            <span>\n' +
            '                                <span>' + resource.title + '</span>\n' +
            '                            </span>\n' +
            '                            <span style="position: fixed; visibility: hidden; top: 0px; left: 0px;">…</span>\n' +
            '                        </span>\n' +
            '                    </div>\n' +
            '                    <div class="curriculum-item-link--lecture-type-resource-container--2l5ZE">\n' +
            '                        <div class="curriculum-item-link--metadata">\n' +
            '                            <span class="curriculum-item-link--type--ZeQ8O">\n' +
            '                                <span class="ion-ios-play"></span>\n' +
            '                            </span>\n' +
            '                            <span> 2min</span>\n' +
            '                        </div>\n' +
            '                        <div class="resource-list-dropdown--resource-list-container btn-group">\n' +
            '                            <div class="dropdown btn-group btn-group-xs btn-group-default">\n' +
            '                                <ul role="menu" class="dropdown-menu dropdown-menu-right" aria-labelledby="item-3752045-resource-list">\n' +
            '                                    <li role="presentation" class="resource--link--2oe5A">\n' +
            '                                        <a role="menuitem" tabindex="-1" href="javascript:void(0)">\n' +
            '                                            <span class="resource--link-icon--1j-Ru udi udi-file"></span>\n' +
            '                                            <span>Lecture 7</span>\n' +
            '                                        </a>\n' +
            '                                    </li>\n' +
            '                                </ul>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '        </li>');
        if (video) {
            let curriculumItemLink = curriculumEl.find('.curriculum-item-link--title');
            let curriculumItemLinkMeta = curriculumEl.find('.curriculum-item-link--metadata');
            curriculumItemLink.click(() => {
                this.player_.playlist.currentItem(indexOf(this.player_.playlist(), video));
                if (this.playOnSelect) {
                    this.player_.play();
                }
            });
            curriculumItemLinkMeta.click(() => {
                this.player_.playlist.currentItem(indexOf(this.player_.playlist(), video));
                if (this.playOnSelect) {
                    this.player_.play();
                }
            });
        }
        if (resource.file) {
            let downloadEl = $('<button aria-label="Resource list" id="item-3752045-resource-list" role="button" aria-haspopup="true" aria-expanded="false" type="button" class="resource-list-dropdown--compact-dropdown-button--2cV14  btn btn-xs btn-default" style="padding-right: 26px;">\n' +
                '    <i class="udi ion-document-text"></i>\n' +
                '    <span class="resource-list-dropdown--resources-label--1NBQn">Resources</span>\n' +
                '    <span style="position: absolute; right: 12px;">\n' +
                '        <i class="dropdown-caret udi ion-ios-download-outline"></i>\n' +
                '    </span>\n' +
                '</button>');
            curriculumEl.find('.resource-list-dropdown--resource-list-container div').append(downloadEl);
        }
        return curriculumEl;
    }

    update() {
        // replace the playlist items being displayed, if necessary
        const playlist = this.player_.playlist();
        if (this.items.length !== playlist.length) {
            this.createPlaylist_();
            return;
        }

        // the playlist itself is unchanged so just update the selection
        const currentItem = this.player_.playlist.currentItem();
        for (let i = 0; i < this.items.length; i++) {
            let item = this.items[i];
            let el = $('[data-video-id="' + item + '"]');
            if (this.items[currentItem] === item) {
                el.addClass('vjs-selected');
            } else {
                el.removeClass('vjs-selected');
            }
        }
    }
}

const playlistUi = function (options) {
    const player = this;

    if (!player.playlist) {
        throw new Error('videojs-playlist plugin is required by the videojs-playlist-ui plugin');
    }

    if (dom.isEl(options)) {
        videojs.log.warn('videojs-playlist-ui: Passing an element directly to playlistUi() is deprecated, use the "el" option instead!');
        options = {el: options};
    }

    options = videojs.mergeOptions(defaults, options);

    // If the player is already using this plugin, remove the pre-existing
    // PlaylistMenu, but retain the element and its location in the DOM because
    // it will be re-used.
    if (player.playlistMenu) {
        const el = player.playlistMenu.el();

        // Catch cases where the menu may have been disposed elsewhere or the
        // element removed from the DOM.
        if (el) {
            const parentNode = el.parentNode;
            const nextSibling = el.nextSibling;

            // Disposing the menu will remove `el` from the DOM, but we need to
            // empty it ourselves to be sure.
            player.playlistMenu.dispose();
            dom.emptyEl(el);

            // Put the element back in its place.
            if (nextSibling) {
                parentNode.insertBefore(el, nextSibling);
            } else {
                parentNode.appendChild(el);
            }
            options.el = el;
        }
    }

    if (!dom.isEl(options.el)) {
        options.el = findRoot(options.className);
    }
    player.playlistMenu = new PlaylistEdurealMenu(player, options);
};
// register components
videojs.registerComponent('PlaylistEdurealMenu', PlaylistEdurealMenu);

// register the plugin
registerPlugin('playlistUiEdureal', playlistUi);

$(document).ready(async function () {
    let courseElId = 'course-player';
    let courseEl = $('#' + courseElId);
    let courseId = courseEl.attr('data-course-id');
    if (courseEl.length > 0 && courseId && edureal.isLoggedin) {
        // Playlist  UI ---------------------------------
        let playlist = [];
        let sections = [];
        let courseEndpoint =  '/api/course/' + courseId;
        let response = await axios.get(courseEndpoint);
        if (response.status === 200 && response.data.success) {
            let data = response.data.data;
            if (data.sections.length > 0) {
                sections = data.sections;
                for (const section of sections) {
                    for (const lecture of section.lectures) {
                        for (const resource of lecture.resources) {
                            let media = resource.media;
                            if (media && media.ext === 'video') {
                                playlist.push({
                                    id: lecture.id + '_' + resource.id + '_' + media.id,
                                    video_id: lecture.id + '_' + resource.id + '_' + media.id,
                                    name: lecture.title,
                                    description: '',
                                    duration: 45,
                                    sources: [
                                        {
                                            src: media.link,
                                            type: 'video/mp4'
                                        }
                                    ],
                                    thumbnail: [{
                                        srcset: media.image,
                                        type: 'image/jpeg',
                                        media: '(min-width: 400px;)'
                                    }, {
                                        src: media.image
                                    }]
                                });
                            }
                        }
                    }
                }
            }
        }
        let coursePlayer = videojs(courseElId, {
            controls: true,
            autoplay: false,
            preload: false,
            responsive: true,
            fill: true,
            fluid: true,
            fullscreen: true,
            playbackRates: [0.25, 0.5, 0.75, 1, 1.25, 1.5, 1.75, 2],
            inactivityTimeout: 0,
            language: window.edureal.language,
        }, function (e) {});
        if (playlist.length > 0) {
            coursePlayer.getChild('controlBar').addChild('PrevButton', {}, 0);
            // Extend
            coursePlayer.getChild('controlBar').addChild('NextButton', {}, 2);
            coursePlayer.playlist(playlist);
        }
        coursePlayer.playlistUiEdureal({
            sections: sections
        });
    }
});
