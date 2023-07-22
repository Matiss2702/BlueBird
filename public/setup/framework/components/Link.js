export function Link(title, link, onClick) {
  const style = {
    color: "cyan",
    textDecoration: "none",
  };
  const events = {};
  if (onClick) {
    events.click = onClick;
  }
  return {
    type: "a",
    attributes: {
      href: link,
      style: style,
    },
    events: events,
    children: [title],
  };
}
