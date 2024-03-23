import { Link } from "@inertiajs/inertia-react";

export default function Navi() {
    return (
        <>
            <Link href="/reladmini/">
                <button>Dashboard</button>
            </Link>
            <Link href="/reladmini/profile">
                <button>Profile</button>
            </Link>
        </>
    );
}
