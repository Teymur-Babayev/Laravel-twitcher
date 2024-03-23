import { usePage } from "@inertiajs/inertia-react";
import React from "react";

export default function ApplicationLogo() {
    const { logo } = usePage().props;
    return (
        <>
            <div className="bg-black rounded-full p-5">
                <img src={logo} alt="logo" className="h-8" />
            </div>
        </>
    );
}
