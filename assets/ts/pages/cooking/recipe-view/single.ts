import "@styles/pages/cooking/recipe-view/single.scss";
import { AsyncList } from "../../../components/common/async-list";
import { Expander } from "../../../components/common/expander";
import { CharCounter } from "../../../components/common/form/char-counter";
import { IncrementalNumber } from "../../../components/common/form/incremental-number";
import { NumberWidget } from "../../../components/common/form/number-widget";
import { TabNavigation } from "../../../components/common/tab-navigation";
import { ReviewForm } from "../../../components/cooking/form/review-form";
import { RecipeCustomizer } from "../../../components/cooking/recipe-customizer";

AsyncList.init();
CharCounter.init();
Expander.init();
IncrementalNumber.init();
NumberWidget.init();
RecipeCustomizer.init();
ReviewForm.init();
TabNavigation.init();
