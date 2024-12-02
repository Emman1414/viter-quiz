import React from "react";

const Pills = ({ isActive }) => {
  return (
    <span
      className={`text-[8px]  rounded-full w-[50px] border  text-center bg-opacity-20 px-2 py-0.5 ${
        isActive
          ? "bg-success border-success text-success"
          : "bg-gray-600 text-gray-600"
      } `}
    >
      {isActive ? "Active" : "Inactive  "}
    </span>
  );
};

export default Pills;
