import { BrowserLink } from "../components/BrowserRouter.js";

export default function Page1() {
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
