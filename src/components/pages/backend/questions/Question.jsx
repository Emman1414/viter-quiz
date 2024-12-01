import { Plus } from "lucide-react";
import React from "react";
import Header from "../partials/Header";
import SearchBar from "../partials/SearchBar";
import Footer from "../partials/Footer";
import SideNavigation from "../partials/SideNavigation";

import { StoreContext } from "@/components/store/storeContext";
import { setIsAdd } from "@/components/store/storeAction";
import ModalAddQuestion from "./ModalAddQuestion";
import ModalError from "../partials/modals/ModalError";
import ToastSuccess from "../partials/ToastSuccess";
import ModalValidation from "../partials/modals/ModalValidation";
import QuestionTable from "./QuestionTable";

const Question = () => {
    const { dispatch, store } = React.useContext(StoreContext);

    const handleAdd = () => {
      dispatch(setIsAdd(true));
    };
  return (
    <>
      <section className="layout-main">
        <div className="layout-division">
          <SideNavigation menu="question" />
          <main>
            <Header
              title="Question"
              subtitle="Manage All Questions"
            />
            <div className="p-8">
              <div className="flex justify-between items-center ">
                <SearchBar />

                <button className="btn btn-add" >
                  <Plus size={16} />
                  Add New
                </button>
              </div>
              <QuestionTable />
            </div>
            <Footer />
          </main>
        </div>
      </section>

      {store.validate && <ModalValidation />}
      {store.error && <ModalError />}
      {store.success && <ToastSuccess />}
      {/* <SpinnerWindow /> */}

      {store.isAdd && <ModalAddQuestion />}
    </>
  );
};

export default Question;
