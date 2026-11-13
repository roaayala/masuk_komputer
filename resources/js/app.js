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
  Eye,
  FileText,
  Lightbulb,
  List,
  Menu,
  MousePointerClick,
  Phone,
  UserGroup,
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
      Lightbulb,
      Phone,
      Cpu,
      FileText,
      // page-about-us (MasukKomputer)
      List,
      Eye,
      MousePointerClick,
      UserGroup,
      // front-page (MasukKomputer)
    },
  });
};

window.initLucideIcons = initLucideIcons;

window.Alpine = Alpine;
Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
  initLucideIcons();
});
