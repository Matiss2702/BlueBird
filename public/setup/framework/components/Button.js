//export default function Button({ title, onClick, style }) {
//  const baseStyle = {
//    backgroundColor: "grey",
//    borderRadius: "5px",
//  };
//  return createElement(
//    "button",
//    {
//      onClick: onClick,
//      style: { ...baseStyle, ...style },
//    },
//    [title]
//  );
//}

export default function Button({ title, onClick, style }) {
  const baseStyle = {
    backgroundColor: "grey",
    borderRadius: "5px",
  };
  return {
    type: "button",
    attributes: {
      style: { ...baseStyle, ...style },
    },
    events: {
      click: onClick,
    },
    children: [title],
  };
}
