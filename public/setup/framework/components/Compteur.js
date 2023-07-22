import Button from "./Button.js";

export default function Compteur({ initialValue = 0 }) {
  let compteur = initialValue;

  return {
    type: "div",
    children: [
      Button({
        title: "-",
        style: { backgroundColor: "red" },
        onClick: () => compteur--,
      }),
      "Current compteur: {{compteur}}",
      Button({
        title: "+",
        style: { backgroundColor: "green" },
        onClick: () => compteur++,
      }),
    ],
  };
}
