import DomRenderer from "../core/DomRenderer.js";
import { Link } from "./Link.js";

let routerBasePath;

export default function BrowserRouter(routes, rootElement, baseUrl = "") {
  routerBasePath = baseUrl;
  const pathname = location.pathname.replace(routerBasePath, "");
  rootElement.appendChild(DomRenderer(routes[pathname]()));

  const oldPushState = history.pushState;
  history.pushState = function (data, unused, url) {
    oldPushState.call(history, data, unused, url);
    window.dispatchEvent(new Event("popstate"));
  };

  window.addEventListener("popstate", function () {
    const pathname = location.pathname.replace(routerBasePath, "");

    rootElement.replaceChild(
      DomRenderer(routes[pathname]()),
      rootElement.childNodes[0]
    );
  });
}

export function BrowserLink(title, link) {
  const realLink = routerBasePath + link;
  return Link(title, realLink, (event) => {
    event.preventDefault();
    history.pushState({}, undefined, realLink);
  });
}
