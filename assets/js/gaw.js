import { lowView, moderateView, highView, defaultView } from "./gaw-views.js";

const infoBar = document.querySelector("gaw-info-bar");
const shadowRoot = infoBar.shadowRoot;
const infoBarOptions = shadowRoot.querySelector("gaw-info-bar-manual button");
const infoBarGridZone = shadowRoot.querySelector(".holder.location p");
const infoBarGridStatus = shadowRoot.querySelector(
  ".holder.grid-status > .split-content p",
);
const svgCircle = shadowRoot.querySelector(".holder.grid-status svg circle");

const getCookies = () => {
  const cookies = document.cookie.split(";").reduce((acc, cookie) => {
    const [key, value] = cookie.trim().split("=");
    acc[key] = value;
    return acc;
  }, {});

  return cookies;
};

const applyHtmlChanges = (view) => {
  if (view === "low") {
    lowView();
    svgCircle.setAttribute("fill", "#86CA7A");
  } else if (view === "moderate") {
    moderateView();
    svgCircle.setAttribute("fill", "ECA75D");
  } else if (view === "high") {
    highView();
    svgCircle.setAttribute("fill", "#E4A08A");
  } else {
    defaultView();
  }
};

const manualView = (cookies) => {
  if (cookies["gaw-manual-view"]) {
    let selectedView = null;

    if (infoBarOptions) {
      infoBarOptions.forEach((button) => {
        if (cookies["gaw-manual-view"] === button.value) {
          selectedView = button.value;
        }
      });
    } else {
      if (
        cookies["gaw-manual-view"] === "low" ||
        cookies["gaw-manual-view"] === "moderate" ||
        cookies["gaw-manual-view"] === "high"
      ) {
        selectedView = cookies["gaw-manual-view"];
      }
    }

    if (selectedView) {
      applyHtmlChanges(selectedView);
      return true;
    }

    return false;
  }
};

const checkUserOptIn = (cookies) => {
  // Handle user opt-in
  if (!cookies["gaw-user-opt-in"]) {
    // Set the cookie
    document.cookie = "gaw-user-opt-in=false; path=/; SameSite=lax;";
    return false; // User hasn't opted-in
  }

  if (cookies["gaw-user-opt-in"] === "true") {
    return true;
  }

  return false;
};

const runGaw = async () => {
  const cookies = getCookies();
  const hasManualView = manualView(cookies);
  let userOptIn = false;
  if (!hasManualView) {
    userOptIn = checkUserOptIn(cookies);
    if (userOptIn) {
      // We have setup a Cloudflare proxy to make the Electricity Maps request.
      // This is to prevent our API key from being exposed.
      // In the proxy, we have hard coded the location to somewhere in the UK:
      // const lat = 54.5667363;
      // const lon = -1.3461574;

      const getEMapsData = await fetch(
        "https://branch-staging-gaw-temp.misty-waterfall-ec66.workers.dev/",
        {
          method: "GET",
          headers: {
            "Content-Type": "application/json",
          },
        },
      );

      const gridIntensity = await getEMapsData.json();

      infoBarGridZone.innerHTML = "United Kingdom";
      // console.log(gridIntensity);

      if (gridIntensity.data.data[0].level === "low") {
        applyHtmlChanges("low");
        infoBarGridStatus.innerHTML = "Your local grid: Cleaner than average.";
      } else if (gridIntensity.data.data[0].level === "moderate") {
        applyHtmlChanges("moderate");
        infoBarGridStatus.innerHTML =
          "Your local grid: Around average emissions.";
      } else if (gridIntensity.data.data[0].level === "high") {
        applyHtmlChanges("high");
        infoBarGridStatus.innerHTML = "Your local grid: Dirtier than average.";
      } else {
        console.error(
          "Unexpected grid intensity level:",
          gridIntensity.data.data[0],
        );
      }
    }
  }
};

runGaw();
