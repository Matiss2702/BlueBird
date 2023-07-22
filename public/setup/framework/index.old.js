function Page1() {
  const DATA_KEY = "data";
  const table = document.createElement("table");
  const tbody = document.createElement("tbody");

  let data = localStorage.getItem(DATA_KEY);
  if (!data) {
    data = {};
  } else {
    data = JSON.parse(data);
  }

  table.appendChild(tbody);
  for (let i = 0; i < 5; i++) {
    const tr = document.createElement("tr");
    tbody.appendChild(tr);
    for (let j = 0; j < 5; j++) {
      const td = document.createElement("td");
      tr.appendChild(td);
      td.dataset.key = `${i}-${j}`;
      const text = document.createTextNode(data[td.dataset.key] ?? "text");
      td.appendChild(text);
      td.addEventListener("click", changeTextIntoInput);
    }
  }

  function changeTextIntoInput(event) {
    const td = event.currentTarget;
    const textNode = td.childNodes[0];
    const text = textNode.textContent;
    const input = document.createElement("input");
    input.value = text;
    td.removeChild(textNode);
    td.appendChild(input);
    input.focus();
    td.removeEventListener("click", changeTextIntoInput);
    input.addEventListener("blur", changeInputIntoText);
  }

  function changeInputIntoText(event) {
    const input = event.currentTarget;
    const textNode = document.createTextNode(input.value);
    data[input.parentNode.dataset.key] = input.value;
    localStorage.setItem(DATA_KEY, JSON.stringify(data));
    input.removeEventListener("blur", changeInputIntoText);
    input.parentNode.addEventListener("click", changeTextIntoInput);
    input.parentNode.replaceChild(textNode, input);
  }

  return table;
}

function Page2() {
  const h1 = document.createElement("h1");
  h1.appendChild(document.createTextNode("Coucou"));

  return h1;
}

const routes = {
  "/page1": function () {
    return generateStructure(Page1Structure());
  },
  "/page2": function () {
    return generateStructure(Page2Structure());
  },
};

const root = document.getElementById("root");

function HashRouter(routes, rootElement) {
  const pathname = location.hash.slice(1);
  rootElement.appendChild(routes[pathname]());

  window.onhashchange = function () {
    const pathname = location.hash.slice(1);
    rootElement.replaceChild(routes[pathname](), rootElement.childNodes[0]);
  };
}

function BrowserRouter(routes, rootElement) {
  const pathname = location.pathname;
  rootElement.appendChild(routes[pathname]());

  const oldPushState = history.pushState;
  history.pushState = function (data, unused, url) {
    oldPushState.call(history, data, unused, url);
    window.dispatchEvent(new Event("popstate"));
  };

  window.addEventListener("popstate", function () {
    const pathname = location.pathname;

    rootElement.replaceChild(routes[pathname](), rootElement.childNodes[0]);
  });
}
BrowserRouter(routes, root);

const page1 = {
  attributes: {},
  children: [
    "Coucou",
    {
      type: "",
      children: [],
    },
  ],
  type: "",
  events: {},
};

function generateStructure(structure) {
  const element = document.createElement(structure.type);
  if (structure.attributes) {
    for (let attrName in structure.attributes) {
      if (attrName.startsWith("data-")) {
        element.dataset[attrName.replace("data-", "")] =
          structure.attributes[attrName];
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

function Page2Structure() {
  return {
    type: "div",
    children: [
      BrowserLink("Page 1", "/page1"),
      {
        type: "h1",
        children: ["Coucou"],
      },
      {
        type: "h2",
        children: ["Bonsoir"],
      },
      {
        type: "h3",
        children: ["Tout le monde"],
      },
      {
        type: "p",
        children: ["Ici le javascript"],
      },
    ],
  };
}

function Page1Structure() {
  const DATA_KEY = "data";
  let data = localStorage.getItem(DATA_KEY);
  if (!data) {
    data = {};
  } else {
    data = JSON.parse(data);
  }

  return {
    type: "div",
    children: [
      BrowserLink("Page 2", "/page2"),
      {
        type: "table",
        children: [
          {
            type: "tbody",
            children: Array.from({ length: 5 }, function (_, i) {
              return {
                type: "tr",
                children: Array.from({ length: 5 }, function (_, j) {
                  return {
                    type: "td",
                    attributes: {
                      "data-key": `${i}-${j}`,
                    },
                    children: [data[`${i}-${j}`] ?? "text"],
                    events: {
                      click: changeTextIntoInput,
                    },
                  };
                }),
              };
            }),
          },
        ],
      },
    ],
  };

  function changeTextIntoInput(event) {
    const td = event.currentTarget;
    const textNode = td.childNodes[0];
    const text = textNode.textContent;
    const input = document.createElement("input");
    input.value = text;
    td.removeChild(textNode);
    td.appendChild(input);
    input.focus();
    td.removeEventListener("click", changeTextIntoInput);
    input.addEventListener("blur", changeInputIntoText);
  }

  function changeInputIntoText(event) {
    const input = event.currentTarget;
    const textNode = document.createTextNode(input.value);
    data[input.parentNode.dataset.key] = input.value;
    localStorage.setItem(DATA_KEY, JSON.stringify(data));
    input.removeEventListener("blur", changeInputIntoText);
    input.parentNode.addEventListener("click", changeTextIntoInput);
    input.parentNode.replaceChild(textNode, input);
  }
}

function HashLink(title, link) {
  return {
    type: "a",
    attributes: {
      href: "#" + link,
    },
    children: [title],
  };
}

function BrowserLink(title, link) {
  return {
    type: "a",
    attributes: {
      href: link,
    },
    children: [title],
    events: {
      click: function (event) {
        event.preventDefault();
        history.pushState({}, undefined, link);
      },
    },
  };
}
