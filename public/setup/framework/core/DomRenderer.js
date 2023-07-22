export default function generateStructure(structure) {
  const element = document.createElement(structure.type);
  if (structure.attributes) {
    for (let attrName in structure.attributes) {
      if (attrName.startsWith("data-")) {
        element.dataset[attrName.replace("data-", "")] =
          structure.attributes[attrName];
      } else if (attrName === "style") {
        Object.assign(element.style, structure.attributes[attrName]);
      } else element.setAttribute(attrName, structure.attributes[attrName]);
    }
  }
  if (structure.events) {
    for (let eventName in structure.events) {
      element.addEventListener(eventName, structure.events[eventName]);
    }
  }

  if (structure.children) {
    for (let child of structure.children) {
      let subChild;
      if (typeof child === "string") {
        subChild = document.createTextNode(child);
      } else {
        subChild = generateStructure(child);
      }
      element.appendChild(subChild);
    }
  }

  return element;
}
