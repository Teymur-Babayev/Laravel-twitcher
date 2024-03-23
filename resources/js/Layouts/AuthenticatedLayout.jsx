import React from "react";
import Front from "./Front";

export default function Authenticated({ auth, children }) {
    return <Front>{children}</Front>;
}
