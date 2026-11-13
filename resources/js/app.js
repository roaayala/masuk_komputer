import {
  ArrowRight,
  ChevronDown,
  ChevronLeft,
  ChevronRight,
  Component,
  Cpu,
  createIcons,
  Download,
  ExternalLink,
  FileText,
  Menu,
  Phone,
  X,
} from "lucide";
import Alpine from "alpinejs";

const initLucideIcons = () => {
  createIcons({
    icons: {
      // common
      ArrowRight,
      ChevronDown,
      ChevronLeft,
      ChevronRight,
      Component,
      Download,
      ExternalLink,
      Menu,
      X,
      Cpu,
      FileText,
      Phone,
    },
  });
};

window.initLucideIcons = initLucideIcons;

window.Alpine = Alpine;
Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
  initLucideIcons();
});
