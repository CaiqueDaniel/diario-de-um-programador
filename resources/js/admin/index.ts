import Modules from "./modules/Modules";
import Pages from "./pages/Pages";

window.addEventListener('DOMContentLoaded', () => {
    new Modules().run();
    new Pages().run();
});
