import __ from "@/Functions/Translate";
import { useState, useEffect } from "react";
import axios from "axios";
import Spinner from "@/Components/Spinner";
import { usePage } from "@inertiajs/inertia-react";
import PrimaryButton from "@/Components/PrimaryButton";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TimePicker from "react-time-picker";
import TextInput from "@/Components/TextInput";
import NumberInput from "@/Components/NumberInput";
import { toast } from "react-toastify";
import { Inertia } from "@inertiajs/inertia";

export default function SetSchedule() {
    const { auth } = usePage().props;
    const user = auth.user;
    const [loading, setLoading] = useState(true);
    const [schedule, setSchedule] = useState({});
    const [scheduleInfo, setInfo] = useState("");

    useEffect(() => {
        getSchedule();
        getScheduleInfo();
    }, []);

    const getSchedule = () => {
        axios
            .get(route("schedule.get", { user: user.id }))
            .then((resp) => {
                console.log(resp.data);
                setSchedule(resp.data);
                setLoading(false);
            })
            .catch((Err) => toast.error(Err.response?.data?.message));
    };

    const getScheduleInfo = () => {
        axios
            .get(route("schedule.getInfo", { user: user.id }))
            .then((resp) => {
                setInfo(resp.data);
                setLoading(false);
            })
            .catch((Err) => toast.error(Err.response?.data?.message));
    };

    const submit = (e) => {
        e.preventDefault();

        Inertia.visit(route("schedule.save"), {
            method: "POST",
            data: { schedule, scheduleInfo },
            preserveScroll: true,
            onBefore: () => setLoading(true),
            onFinish: () => setLoading(false),
            onError: (Error) => toast.error(Error.response?.data?.message),
        });
    };

    const updateSchedule = (dayName, key, value) => {
        console.log(
            `Would update Day: ${dayName}, Key: ${key}, Value: ${value}`
        );

        setSchedule({
            ...schedule,
            [dayName]: {
                ...schedule[dayName],
                [key]: value,
            },
        });
    };

    return (
        <>
            <header className="mt-10 border-t pt-10">
                <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {__("Streaming Schedule")}
                </h2>

                <p className="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {__(
                        "Set your streaming schedule for users to get an idea on your live times"
                    )}
                </p>
            </header>

            {loading && (
                <div className="my-5">
                    <Spinner />
                </div>
            )}

            <form onSubmit={submit}>
                <div className="mt-4">
                    <TextInput
                        value={scheduleInfo}
                        className="w-full"
                        placeholder={__(
                            "Enter schedule info like All times in PST, etc."
                        )}
                        handleChange={(e) => setInfo(e.target.value)}
                    />
                </div>
                <div className="mt-4">
                    {Object.keys(schedule).map((key, index) => {
                        return (
                            <div key={`schedule-${index}`}>
                                <div className="flex mb-5 md:items-center flex-col md:flex-row md:space-x-2">
                                    <div className="md:w-24 md:text-sm mb-2 md:mb-0 text-gray-600 bg-gray-200 rounded-lg py-3 text-center">
                                        {schedule[key].day_name}
                                    </div>

                                    <div className="flex items-center space-x-2">
                                        <NumberInput
                                            type="number"
                                            max={12}
                                            min={0}
                                            name={`${schedule[key].day_name}_from_hour`}
                                            value={
                                                schedule[key].from_hour || ""
                                            }
                                            className="w-full md:w-20"
                                            handleChange={(e) =>
                                                updateSchedule(
                                                    key,
                                                    "from_hour",
                                                    e.target.value
                                                )
                                            }
                                        />
                                        <span className="py-2 px-3 text-gray-600 bg-gray-200 rounded-lg">
                                            :
                                        </span>
                                        <NumberInput
                                            type="number"
                                            max={59}
                                            min={0}
                                            name={`${schedule[key].day_name}_from_minute`}
                                            value={
                                                schedule[key].from_minute || ""
                                            }
                                            className="w-full md:w-20"
                                            handleChange={(e) =>
                                                updateSchedule(
                                                    key,
                                                    "from_minute",
                                                    e.target.value
                                                )
                                            }
                                        />
                                        <select
                                            name={`${schedule[key].day_name}_from_type`}
                                            value={schedule[key].from_type}
                                            onChange={(e) =>
                                                updateSchedule(
                                                    key,
                                                    "from_type",
                                                    e.target.value
                                                )
                                            }
                                            required
                                            className={` border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm `}
                                        >
                                            <option value={"AM"}>
                                                {__("AM")}
                                            </option>
                                            <option value={"PM"}>
                                                {__("PM")}
                                            </option>
                                        </select>
                                    </div>
                                    <InputLabel className="my-3 md:my-0">
                                        {__("To")}
                                    </InputLabel>

                                    <div className="flex items-center space-x-2">
                                        <NumberInput
                                            className="w-full md:w-20"
                                            type="number"
                                            max={12}
                                            min={0}
                                            value={schedule[key].to_hour || ""}
                                            name={`${schedule[key].day_name}_to_hour`}
                                            handleChange={(e) =>
                                                updateSchedule(
                                                    key,
                                                    "to_hour",
                                                    e.target.value
                                                )
                                            }
                                        />
                                        <span className="py-2 px-3 text-gray-600 bg-gray-200 rounded-lg">
                                            :
                                        </span>
                                        <NumberInput
                                            className="w-full md:w-20"
                                            type="number"
                                            max={59}
                                            min={0}
                                            value={
                                                schedule[key].to_minute || ""
                                            }
                                            name={`${schedule[key].day_name}_to_minute`}
                                            handleChange={(e) =>
                                                updateSchedule(
                                                    key,
                                                    "to_minute",
                                                    e.target.value
                                                )
                                            }
                                        />
                                        <select
                                            name={`${schedule[key].day_name}_to_type`}
                                            value={schedule[key].to_type}
                                            onChange={(e) =>
                                                updateSchedule(
                                                    key,
                                                    "to_type",
                                                    e.target.value
                                                )
                                            }
                                            required
                                            className={`w-20 border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm `}
                                        >
                                            <option value={"AM"}>
                                                {__("AM")}
                                            </option>
                                            <option value={"PM"}>
                                                {__("PM")}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        );
                    })}
                </div>

                <PrimaryButton processing={loading} className="mt-5">
                    {__("Save")}
                </PrimaryButton>
            </form>
        </>
    );
}
