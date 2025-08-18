export const lowView = () => {
  const body = document.querySelector("body");
  body.setAttribute("data-gaw-mode", "low");
};

export const moderateView = () => {
  const body = document.querySelector("body");
  body.setAttribute("data-gaw-mode", "moderate");
};

export const highView = () => {
  const body = document.querySelector("body");
  body.setAttribute("data-gaw-mode", "high");
};

export const defaultView = () => {
  const body = document.querySelector("body");
  body.setAttribute("data-gaw-mode", "default");
};
