import BrowserRouter from "./components/BrowserRouter.js";
import routes from "./routes.js";

const root = document.getElementById("root");
BrowserRouter(routes, root, root.dataset.baseurl);
