import "@styles/pages/cooking/recipe-view/single.scss";
import { Expander } from "../../../components/common/expander";
import { AsyncForm } from "../../../components/common/form/async-form";
import { CharCounter } from "../../../components/common/form/char-counter";
import { IncrementalNumber } from "../../../components/common/form/incremental-number";
import { NumberWidget } from "../../../components/common/form/number-widget";
import { TabNavigation } from "../../../components/common/tab-navigation";
import { RecipeCustomizer } from "../../../components/cooking/recipe-customizer";

AsyncForm.init();
CharCounter.init();
Expander.init();
IncrementalNumber.init();
NumberWidget.init();
RecipeCustomizer.init();
TabNavigation.init();
