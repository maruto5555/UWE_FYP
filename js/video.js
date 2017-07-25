/**
 * Created by wong on 2/22/2017.
 */
/*
 * Copyright 2016 Google Inc. All Rights Reserved.
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
var vrView;
var playButton;
var muteButton;


function onVRViewReady() {
    console.log('vrView.isPaused', vrView.isPaused);
    // Set the initial state of the buttons.
    if (vrView.isPaused) {
        playButton.classList.add('paused');
    } else {
        playButton.classList.remove('paused');
    }
}

function onTogglePlay() {
    if (vrView.isPaused) {
        vrView.play();
        playButton.classList.remove('paused');
    } else {
        vrView.pause();
        playButton.classList.add('paused');
    }
}

function onToggleMute() {
    var isMuted = muteButton.classList.contains('muted');
    if (isMuted) {
        vrView.setVolume(1);
    } else {
        vrView.setVolume(0);
    }
    muteButton.classList.toggle('muted');
}


