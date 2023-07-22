import { BrowserLink } from "../components/BrowserRouter.js";
import Button from "../components/Button.js";
import Compteur from "../components/Compteur.js";
import { Link } from "../components/Link.js";

export default function Page2() {
  return {
    type: "div",
    children: [
      BrowserLink("Page 1", "/page1"),
      Link("Index", "/"),
      Link("Page 1", "/articles/page1"),
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
      // Version alternative : plus facile pour l'update
      // {
      //   type: Button,
      //   attributes: {
      //     title: "Coucou button",
      //     style: {
      //       backgroundColor: "blue",
      //       color: "white",
      //     },
      //     onClick: () => alert("coucou"),
      //   },
      // },
      Button({
        title: "Coucou button",
        style: {
          backgroundColor: "blue",
          color: "white",
        },
        onClick: () => alert("coucou"),
      }),
      // Version alternative : plus facile pour l'update
      //{
      //  type: Compteur,
      //  attributes: {
      //    initialValue: 10
      //  }
      //},
      Compteur({ initialValue: 10 }),
    ],
  };
}
