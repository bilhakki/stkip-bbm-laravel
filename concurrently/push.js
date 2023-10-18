import concurrently from "concurrently";

const { result } = concurrently(
    [
        {
            command: `pnpm build && git add . && git commit -m="build ${Date.now()}" && git push`,
            name: "script",
            env: { APP_ENV: "production" },
        },
    ],
    {
        restartTries: 1,
    },
);

function success() {
    console.log("success");
    fetch("https://sia.resamja.com/pull").then(res => res.json()).then(json => {
        console.log(json);
    }).catch(error => {
        console.error("Terjadi error: ", error);
    })
}
function failure() {
    console.log("failure");
}
result.then(success, failure);
