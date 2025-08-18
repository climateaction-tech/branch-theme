// Set the regex to match the image URLs
const moderateImageRegex = /(\d{4})\/(\d{2})\//gi;

// Regex to find YouTube video ID
const ytIdRegex =
  /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;

function getYoutubeID(url) {
  var match = url.match(ytIdRegex);
  return match && match[7].length == 11 ? match[7] : false;
}

const body = document.querySelector("body");
const imageElements = document.querySelectorAll(
  ".entry-content .wp-block-image figure:not(.no-carbon) img, .entry-content figure.wp-block-image:not(.no-carbon) img, .entry-content figure.wp-block-gallery figure:not(.no-carbon) img",
);
const imageFigureElements = document.querySelectorAll(
  ".entry-content .wp-block-image figure:not(.no-carbon), .entry-content figure.wp-block-image:not(.no-carbon), .entry-content figure.wp-block-gallery figure:not(.no-carbon)",
);
const pictureElements = document.querySelectorAll(
  ".entry-content .wp-block-image figure:not(.no-carbon) picture source, .entry-content figure.wp-block-image:not(.no-carbon) picture source, .entry-content figure.wp-block-gallery figure:not(.no-carbon) picture source",
);
const youTubeElements = document.querySelectorAll('iframe[src*="youtube"]');

function replaceYouTube() {
  youTubeElements.forEach((iframe) => {
    // Extract attributes from the iframe
    const src = iframe.getAttribute("src");
    const id = getYoutubeID(src);
    const className = iframe.getAttribute("class") || "";

    // Parse URL parameters
    let params = "";
    try {
      params = new URL(src).searchParams.toString();
    } catch (e) {
      console.error("Error parsing YouTube URL:", e);
    }

    // Get dimensions with fallbacks
    const width = iframe.getAttribute("width") || "100%";
    const height = iframe.getAttribute("height") || "auto";

    // Create the replacement element
    const wrapper = document.createElement("div");
    wrapper.style.cssText = `width: ${width}px; height: ${height}px; margin-inline: auto;`;

    // Set the inner HTML for the lite-youtube element
    wrapper.innerHTML = `<lite-youtube class="${className}" videoid="${id}" nocookie params='${params}'> </lite-youtube>`;

    // Replace the iframe with our custom element
    if (iframe.parentNode) {
      iframe.parentNode.replaceChild(wrapper, iframe);

      // Add the script for the lite-youtube component if it's not already present
      if (!document.querySelector('script[src*="lite-youtube.js"]')) {
        const script = document.createElement("script");
        script.type = "module";
        script.src =
          "https://cdn.jsdelivr.net/npm/@justinribeiro/lite-youtube@1.3.1/lite-youtube.js";
        document.body.appendChild(script);
      }
    }
  });
}

export const lowView = () => {
  body.setAttribute("data-gaw-mode", "low");

  // Loop through each element and apply the style modification
  imageElements.forEach((element) => {
    // Get the current style attribute or an empty string if none exists
    const style = element.getAttribute("style") || "";

    // Append the display property to the style attribute
    element.setAttribute("style", style + "display: initial !important;");
  });

  replaceYouTube();
};

export const moderateView = () => {
  body.setAttribute("data-gaw-mode", "moderate");

  // Loop through each element and apply the style modification
  imageElements.forEach((element) => {
    const src = element.getAttribute("src");
    element.setAttribute(
      "src",
      src?.replace(moderateImageRegex, "$1/$2/low-res/"),
    );
    const srcset = element.getAttribute("srcset");
    element.setAttribute(
      "srcset",
      srcset?.replaceAll(moderateImageRegex, "$1/$2/low-res/"),
    );
    const style = element.getAttribute("style") || "";
    element.setAttribute("style", style + "display: initial !important;");
  });

  pictureElements.forEach((element) => {
    const srcset = element.getAttribute("srcset");
    srcset?.replaceAll(moderateImageRegex, "$1/$2/low-res/");
  });

  replaceYouTube();
};

export const highView = () => {
  body.setAttribute("data-gaw-mode", "high");

  imageFigureElements.forEach((element) => {
    // Get the current style attribute or an empty string if none exists
    const style = element.getAttribute("style") || "";

    // Append the display property to the style attribute
    element.setAttribute("style", style + "position: relative;");
  });

  imageElements.forEach((element) => {
    // Get image attributes
    // const height = element.getAttribute('height');
    // const width = element.getAttribute('width');
    const altText = element.getAttribute("alt") || "";
    const src = element.getAttribute("src");
    const srcset = element.getAttribute("srcset");

    // Store original image sources as data attributes
    element.setAttribute("data-full-src", src);
    element.setAttribute("data-full-srcset", srcset);

    // Replace image sources with low-resolution versions
    if (src) {
      element.setAttribute(
        "src",
        src.replace(moderateImageRegex, "$1/$2/low-res/"),
      );
    }

    if (srcset) {
      element.setAttribute(
        "srcset",
        srcset.replaceAll(moderateImageRegex, "$1/$2/low-res/"),
      );
    }

    // Set display style
    element.setAttribute("style", "display: block;");

    // Create the overlay element
    const overlay = document.createElement("span");
    overlay.style.cssText =
      "width: 100%; height: 100%; display: inline-flex; z-index: 1; top: 0; left: 0; position: absolute; background-color: var(--bg-colour-dark); flex-direction: column; align-items: center; justify-content: space-evenly; padding: 0.5rem;";

    // Set the inner HTML for the overlay
    overlay.innerHTML = `
        <div class="carbon-alt" style="position: relative; transform: none; top: 0; left: 0;">${altText}</div>
        <div class="show-image" style="position: relative; transform: none; bottom: 0; left: 0;">Show image</div>
      `;

    // Get the parent element for positioning context
    const parent = element.parentElement;
    if (parent) {
      // Make sure the parent has position relative for absolute positioning of the overlay
      if (getComputedStyle(parent).position === "static") {
        parent.style.position = "relative";
      }

      // Insert the overlay after the image
      element.insertAdjacentElement("afterend", overlay);
    }
  });

  const imageClickScript = document.createElement("script");
  imageClickScript.textContent = `
    document.querySelectorAll('.show-image').forEach((el) => {
									el.addEventListener('click', (e) => {
										const parent = e.target.parentElement;
										const img = parent.previousElementSibling;
										const style = img.getAttribute('style') || '';
										img.setAttribute('style', style + 'display: initial !important;');

										const src = img.getAttribute('data-full-src');
										const srcset = img.getAttribute('data-full-srcset');

										img.setAttribute('src', src);
										img.setAttribute('srcset', srcset);

										img.setAttribute('data-full-src', '');
										img.setAttribute('data-full-srcset', '');
										parent.remove();
									});
								});`;

  body.appendChild(imageClickScript);

  const fontsCSS = document.querySelector('link[href*="fonts.css"]');
  fontsCSS.remove();

  const fontsPreload = document.querySelector('link[rel="preload"][as="font"]');
  fontsPreload.remove();

  replaceYouTube();

  const pdfEmbed = document.querySelectorAll(".pdf-embed-download");

  pdfEmbed.forEach((embed) => {
    const href = embed.getAttribute("href");

    embed.replaceWith(
      `<a href="${href}" style="color: currentColor; padding: 2.5rem;">Download the PDF</a>`,
    );
  });

  const pdfViewer = document.querySelectorAll(".pdfemb-viewer");

  pdfViewer.forEach((viewer) => {
    viewer.remove();
  });
};

export const defaultView = () => {
  body.setAttribute("data-gaw-mode", "default");
};
