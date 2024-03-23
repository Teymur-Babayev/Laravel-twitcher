import React from "react";
import Front from "@/Layouts/Front";
import __ from "@/Functions/Translate";
import { useState, useEffect, useRef } from "react";
import PrimaryButton from "@/Components/PrimaryButton";
import ChatRoom from "./ChatRoom";
import VideoJS from "./Partials/VideoJs";
import StreamInstructions from "./StreamInstructions";
import { usePage } from "@inertiajs/inertia-react";

export default function LiveStream({ isChannelOwner, streamUser, roomName }) {
  const [isRoomOffline, setIsRoomOffline] = useState(
    streamUser.live_status === "online" ? false : true
  );

  const [showMessage, setShowMessage] = useState(true);

  const { auth } = usePage().props;

  console.info(`${route("home")}/livestreams/${roomName}.m3u8`);

  const playerRef = useRef(null);

  const videoJsOptions = {
    autoplay: false,
    controls: true,
    responsive: true,
    fill: true,
    preload: "auto",
    fluid: true,
    sources: [
      {
        src: `${route("home")}/livestreams/${roomName}.m3u8`,
        type: "application/x-mpegURL",
      },
    ],
  };

  const handlePlayerReady = (player) => {
    playerRef.current = player;

    // You can handle player events here, for example:
    player.on("waiting", () => {
      console.log("player is waiting");
    });

    player.on("dispose", () => {
      console.log("player will dispose");
    });
  };

  // stream setup
  useEffect(() => {
    window.Echo.channel("LiveStreamRefresh").listen(
      ".livestreams.refresh",
      (data) => {
        console.log(`refresh livestreams`);
        Inertia.reload();
      }
    );

    // listen for live streaming events
    window.Echo.channel(`room-${streamUser.username}`)
      .listen(".livestream.started", (data) => {
        setIsRoomOffline(false);
      })
      .listen(".livestream.ban", (data) => {
        window.location.href = route("channel.bannedFromRoom", {
          user: streamUser.username,
        });
      })
      .listen(".livestream.stopped", (data) => {
        setIsRoomOffline(true);
      });
  }, []);

  return (
    <Front
      extraHeader={true}
      extraHeaderTitle={__("@:username's Live Stream", {
        username: streamUser.username,
      })}
      extraHeaderImage="/images/live-stream-icon.png"
      extraImageHeight="h-10"
    >
      <div className="sm:-mt-[70px] -mt-[110px] flex max-w-7xl flex-col lg:flex-row lg:justify-between items-start h-fit">
        <div className="w-full h-full">
          {isRoomOffline ? (
            <StreamInstructions
              streamKey={roomName}
              streamUser={streamUser.username}
            />
          ) : (
            <>
              {streamUser.username === auth?.user?.username && (
                <div
                  className={`${
                    showMessage ? "flex" : "hidden"
                  } mb-3 mt-5 lg:mt-0 p-3 bg-white dark:bg-zinc-800 dark:text-white text-indigo-700 font-medium`}
                >
                  {__(
                    "If you just started streaming in OBS, refresh this page after 30 seconds to see your stream."
                  )}
                  <button
                    className="ml-2 border-b border-indigo-700 dark:border-white"
                    onClick={(e) => setShowMessage(false)}
                  >
                    {__("Close message")}
                  </button>
                </div>
              )}
              <VideoJS options={videoJsOptions} onReady={handlePlayerReady} />
            </>
          )}
        </div>
        <ChatRoom streamer={streamUser} />
      </div>
    </Front>
  );
}
