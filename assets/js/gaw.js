import { lowView, moderateView, highView, defaultView } from "./gaw-views.js";

const infoBar = document.querySelector("gaw-info-bar");
const shadowRoot = infoBar.shadowRoot;
const infoBarOptions = shadowRoot.querySelector("gaw-info-bar-manual button");

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
  } else if (view === "moderate") {
    moderateView();
  } else if (view === "high") {
    highView();
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
    }
  }
};

const runGaw = () => {
  const cookies = getCookies();
  manualView(cookies);
};

runGaw();
