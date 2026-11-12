import {
  createIcons,
  Award,
  MapPin,
  Phone,
  SquareArrowOutUpRight,
  ThumbsUp,
  CircleAlert,
  X,
  Menu,
  MoveLeft,
  MoveRight,
  VectorPolygon,
  Home,
  BedDouble,
  Bath,
  CheckCircle2,
  Building2,
  Eye,
  Target,
  Users,
  ShieldCheck,
  Layers2,
  ChevronRight,
  ChevronLeft,
  ChevronDown,
  ArrowRight,
  Component,
  ChartPie,
  Lightbulb,
  UserGroup,
  MousePointerClick,
  List,
} from "lucide";
import Alpine from "alpinejs";

const initLucideIcons = () => {
  createIcons({
    icons: {
      Award,
      MapPin,
      ThumbsUp,
      Phone,
      SquareArrowOutUpRight,
      CircleAlert,
      Menu,
      X,
      MoveLeft,
      MoveRight,
      VectorPolygon,
      Home,
      BedDouble,
      Bath,
      CheckCircle2,
      Building2,
      Eye,
      Target,
      Users,
      ShieldCheck,
      Layers2,
      ChevronRight,
      ChevronLeft,
      ChevronDown,
      ArrowRight,
      Component,
      ChartPie,
      Lightbulb,
      UserGroup,
      MousePointerClick,
      List,
    },
  });
};

window.initLucideIcons = initLucideIcons;

document.addEventListener("DOMContentLoaded", () => {
  initLucideIcons();
});

window.Alpine = Alpine;
Alpine.start();
