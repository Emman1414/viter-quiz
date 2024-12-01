import { Plus } from "lucide-react";
import React from "react";
import SideNavigation from "../partials/SideNavigation";
import Header from "../partials/Header";
import Searchbar from "../partials/Searchbar";
import Footer from "../partials/Footer";
import QuestionTable from "./QuestionTable";
import { StoreContext } from "@/components/store/storeContext";
import { setIsAdd } from "@/components/store/storeAction";
import ModalAddQuestion from "./ModalAddQuestion";

const Question = () => {
  const { dispatch, store } = React.useContext(StoreContext);

  const handleAdd = () => {
    dispatch(setIsAdd(true));
  };

  return (
    <>
      <section className="layout-main ">
        <div className="layout-division ">
          <SideNavigation menu="question" />
          <main>
            <Header title="Question" subtitle="Manage All Questions" />
            <div className="p-8">
              <div className="flex justify-between items-center">
                <Searchbar />
                <button className="btn btn-add" onClick={handleAdd}>
                  <Plus size={16} /> Add New
                </button>
              </div>

              <QuestionTable />
            </div>

            <Footer />
          </main>
        </div>
      </section>
      {store.validate && <ModalValidatioN />}
      {store.error && <ModalErroR />}
      {store.success && <ToastSuccesS />}
      {store.isAdd && <ModalAddQuestion />}
    </>
  );
};

export default Question;
