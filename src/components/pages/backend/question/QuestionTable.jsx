import {
  setIsAdd,
  setIsConfirm,
  setIsDelete,
} from "@/components/store/storeAction";
import { StoreContext } from "@/components/store/storeContext";
import { Archive, ArchiveRestore, FilePenLine, Trash2 } from "lucide-react";
import React from "react";
import IconNoData from "../partials/IconNoData";
import IconServerError from "../partials/IconServerError";
import ModalConfirm from "../partials/modals/ModalConfirm";
import ModalDelete from "../partials/modals/ModalDelete";
import Pills from "../partials/Pills";
import SpinnerTable from "../partials/spinners/SpinnerTable";
import TableLoader from "../partials/TableLoader";
import useQueryData from "@/components/custom-hook/useQueryData";

const QuestionTable = ({ setItemEdit }) => {
  const { store, dispatch } = React.useContext(StoreContext);
  const [isActive, setIsActive] = React.useState(0);
  const [id, setId] = React.useState(null);

  const {
    isLoading,
    isFetching,
    error,
    data: result,
  } = useQueryData(
    `/v2/question`, // endpoint
    "get", // method
    "question"
  );

  let counter = 1;

  const handleEdit = (item) => {
    dispatch(setIsAdd(true));
    setItemEdit(item);
  };
  const handleDelete = (item) => {
    dispatch(setIsDelete(true));
    setId(item.question_aid);
  };
  const handleRestore = (item) => {
    dispatch(setIsConfirm(true));
    setIsActive(1);
    setId(item.question_aid);
  };
  const handleArchive = (item) => {
    dispatch(setIsConfirm(true));
    setIsActive(0);
    setId(item.question_aid);
  };

  return (
    <>
      <div className="p-4 bg-secondary mt-10 rounded-md border border-line relative">
        {!isLoading || (isFetching && <SpinnerTable />)}{" "}
        <div className="table-wrapper custom-scroll">
          {/* <TableLoader count={20} cols={4} /> */}
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Status</th>
                <th className="w-[50%]">Question</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              {/* <tr>
                <td colSpan={100}>
                  <IconNoData />
                </td>
              </tr>
              <tr>
                <td colSpan={100}>
                  <IconServerError />
                </td>
              </tr> */}
              {((isLoading && !isFetching) || result?.data.length === 0) && (
                <tr>
                  <td colSpan="100%">
                    {isLoading ? (
                      <TableLoader count={30} cols={6} />
                    ) : (
                      <IconNoData />
                    )}
                  </td>
                </tr>
              )}

              {error && (
                <tr>
                  <td colSpan="100%">
                    <IconServerError />
                  </td>
                </tr>
              )}

              {result?.data.map((item, key) => {
                return (
                  <tr key={key}>
                    <td>{counter++}.</td>
                    <td>
                      <Pills isActive={item.question_is_active} />
                    </td>
                    <td>{item.question_title}</td>

                    <td>
                      <ul className="table-action ">
                        {item.question_is_active ? (
                          <>
                            <li>
                              <button
                                className="tooltip"
                                data-tooltip="Edit"
                                onClick={() => handleEdit(item)}
                              >
                                <FilePenLine />
                              </button>
                            </li>
                            <li>
                              <button
                                className="tooltip"
                                data-tooltip="Archive"
                              >
                                <Archive onClick={() => handleArchive(item)} />
                              </button>
                            </li>
                          </>
                        ) : (
                          <>
                            <li>
                              <button
                                className="tooltip"
                                data-tooltip="Restore"
                              >
                                <ArchiveRestore
                                  onClick={() => handleRestore(item)}
                                />
                              </button>
                            </li>
                            <li>
                              <button
                                className="tooltip"
                                data-tooltip="Delete"
                                onClick={() => handleDelete(item)}
                              >
                                <Trash2 />
                              </button>
                            </li>
                          </>
                        )}
                      </ul>
                    </td>
                  </tr>
                );
              })}
            </tbody>
          </table>
        </div>
      </div>

      {store.isDelete && (
        <ModalDelete
          mysqlApiDelete={`/v2/question/${id}`}
          queryKey="question"
        />
      )}

      {store.isConfirm && (
        <ModalConfirm
          queryKey="question"
          mysqlApiArchive={`/v2/question/active/${id}`}
          active={isActive}
        />
      )}
    </>
  );
};

export default QuestionTable;
