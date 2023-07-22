import DomRenderer from "../core/DomRenderer.js";

export function HashLink(title, link) {
  return {
    type: "a",
    attributes: {
      href: "#" + link,
    },
    children: [title],
  };
}

export default function HashRouter(routes, rootElement) {
  const pathname = location.hash.slice(1);
  rootElement.appendChild(DomRenderer(routes[pathname]()));

  window.onhashchange = function () {
    const pathname = location.hash.slice(1);
    rootElement.replaceChild(
      DomRenderer(routes[pathname]()),
      rootElement.childNodes[0]
    );
  };
}
