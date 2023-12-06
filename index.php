<!DOCTYPE html>
<html lang="en">
<head>
    <meta charSet="utf-8" />
    <style>
        .jwplayer {
            position: unset !important;
        }
    </style>
</head>
<body>
    <div id="P2Pplayer"></div>
    <script src="https://cdn.jsdelivr.net/gh/linhminaz/p2p_jwplayer@main/p2p-media-loader-core.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/linhminaz/p2p_jwplayer@main/p2p-media-loader-hlsjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/linhminaz/p2p_jwplayer@main/jwplayer-8.9.3.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/linhminaz/p2p_jwplayer@main/hls.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/linhminaz/p2p_jwplayer@main/jwplayer.hlsjs.min.js"></script>

    <script>
        var episode_id = id = 47756;
        const wrapper = document.getElementById('P2Pplayer');
        renderPlayer(id);
        function renderPlayer(id) {
            wrapper.innerHTML = `<div id="jwplayer"></div>`;
            const player = jwplayer("jwplayer");
            const objSetup = {
                key: "ITWMv7t88JGzI0xPwW8I0+LveiXX9SWbfdmt0ArUSyc=",
                aspectratio: "16:9",
                width: "100%",
                file: "Link_HLS",
                type: "hls",
                playbackRateControls: true,
                playbackRates: [0.25, 0.75, 1, 1.25],
                sharing: {
                    sites: [
                        "reddit",
                        "facebook",
                        "twitter",
                        "googleplus",
                        "email",
                        "linkedin",
                    ],
                },
                volume: 100,
                mute: false,
                autostart: true,
                logo: {
                    file: "",
                    link: "",
                    position: "",
                },
                advertising: {
                    tag: "",
                    client: "vast",
                    vpaidmode: "insecure",
                    skipoffset: 5, // Bỏ qua quảng cáo trong vòng 5 giây
                    skipmessage: "Bỏ qua sau xx giây",
                    skiptext: "Bỏ qua"
                }
            };
            
            const segments_in_queue = 50;
            var engine_config = {
                debug: !1,
                segments: {
                    forwardSegmentCount: 50,
                },
                loader: {
                    cachedSegmentExpiration: 864e5,
                    cachedSegmentsCount: 1e3,
                    requiredSegmentsPriority: segments_in_queue,
                    httpDownloadMaxPriority: 9,
                    httpDownloadProbability: 0.06,
                    httpDownloadProbabilityInterval: 1e3,
                    httpDownloadProbabilitySkipIfNoPeers: !0,
                    p2pDownloadMaxPriority: 50,
                    httpFailedSegmentTimeout: 500,
                    simultaneousP2PDownloads: 20,
                    simultaneousHttpDownloads: 2,
                    // httpDownloadInitialTimeout: 12e4,
                    // httpDownloadInitialTimeoutPerSegment: 17e3,
                    httpDownloadInitialTimeout: 0,
                    httpDownloadInitialTimeoutPerSegment: 17e3,
                    httpUseRanges: !0,
                    maxBufferLength: 300,
                    // useP2P: false,
                },
            };
            if (Hls.isSupported() && p2pml.hlsjs.Engine.isSupported()) {
                var engine = new p2pml.hlsjs.Engine(engine_config);
                player.setup(objSetup);
                jwplayer_hls_provider.attach();
                p2pml.hlsjs.initJwPlayer(player, {
                    liveSyncDurationCount: segments_in_queue, // To have at least 7 segments in queue
                    maxBufferLength: 300,
                    loader: engine.createLoaderClass(),
                });
            } else {
                player.setup(objSetup);
            }

            const resumeData = 'OPCMS-PlayerPosition-' + id;
            player.on('ready', function () {
                if (typeof (Storage) !== 'undefined') {
                    if (localStorage[resumeData] == '' || localStorage[resumeData] == 'undefined') {
                        console.log("No cookie for position found");
                        var currentPosition = 0;
                    } else {
                        if (localStorage[resumeData] == "null") {
                            localStorage[resumeData] = 0;
                        } else {
                            var currentPosition = localStorage[resumeData];
                        }
                        console.log("Position cookie found: " + localStorage[resumeData]);
                    }
                    player.once('play', function () {
                        console.log('Checking position cookie!');
                        console.log(Math.abs(player.getDuration() - currentPosition));
                        if (currentPosition > 180 && Math.abs(player.getDuration() - currentPosition) >
                            5) {
                            player.seek(currentPosition);
                        }
                    });
                    window.onunload = function () {
                        localStorage[resumeData] = player.getPosition();
                    }
                } else {
                    console.log('Your browser is too old!');
                }
            });

            player.on('complete', function () {
                if (typeof (Storage) !== 'undefined') {
                    localStorage.removeItem(resumeData);
                } else {
                    console.log('Your browser is too old!');
                }
            })

            function formatSeconds(seconds) {
                var date = new Date(1970, 0, 1);
                date.setSeconds(seconds);
                return date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
            }
        }
    </script>
</body>
</html>
