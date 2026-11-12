import {
  ArrowRight,
  ChevronDown,
  ChevronLeft,
  ChevronRight,
  Component,
  createIcons,
  Download,
  Hamburger,
} from "lucide";
import Alpine from "alpinejs";

const initLucideIcons = () => {
  createIcons({
    icons: {
      ChevronDown,
      ChevronRight,
      ChevronLeft,
      Hamburger,
      ArrowRight,
      Component,
      Download,
    },
  });
};

window.initLucideIcons = initLucideIcons;

document.addEventListener("DOMContentLoaded", () => {
  initLucideIcons();
});

window.Alpine = Alpine;
Alpine.start();
