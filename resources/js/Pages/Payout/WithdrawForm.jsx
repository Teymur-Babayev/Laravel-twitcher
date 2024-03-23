import TextInput from "@/Components/TextInput";
import { useForm } from "@inertiajs/inertia-react";
import __ from "@/Functions/Translate";
import PrimaryButton from "@/Components/PrimaryButton";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import Spinner from "@/Components/Spinner";

export default function WithdrawForm(props) {
    const { data, setData, post, processing, errors, reset } = useForm({
        tokens: props.tokens,
    });

    const submit = (e) => {
        e.preventDefault();

        post(route("payout.saveRequest"), { preserveState: false });
    };

    if (!props.payout_settings.destination) {
        return (
            <div className="mt-10 dark:text-white bg-sky-200 text-sky-700 rounded-lg px-2 py-1.5">
                {__(
                    "In order to create a payout request, you must first set a destination for the funds in the Settings Tab"
                )}
            </div>
        );
    }

    return (
        <div className="mt-10 text-zinc-600 dark:text-white">
            {props.pending_count === 0 ? (
                <form onSubmit={submit}>
                    <hr className="my-5" />
                    <InputLabel className={"text-lg"}>
                        {__("Request Payout Tokens")}
                    </InputLabel>
                    <div className="flex flex-col md:flex-row md:items-center md:space-x-3 space-y-3 md:space-y-0">
                        <TextInput
                            type="number"
                            handleChange={(e) =>
                                setData("tokens", e.target.value)
                            }
                            value={data.tokens}
                            required
                        />
                        <InputError message={errors.tokens} className="mt-2" />

                        <PrimaryButton
                            className="max-w-24"
                            processing={processing}
                        >
                            {__("Send Request")}
                        </PrimaryButton>

                        {processing && <Spinner />}
                    </div>
                </form>
            ) : (
                <div className="bg-green-100 p-3 text-green-800 rounded-md">
                    {__(
                        "You have a Pending payout request. Check history tab for more infos."
                    )}
                </div>
            )}
        </div>
    );
}
