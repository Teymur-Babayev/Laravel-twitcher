import { useState, useEffect } from "react";
import __ from "@/Functions/Translate";
import axios from "axios";
import { toast } from "react-toastify";
import { VscArrowBoth } from "react-icons/vsc";
import Spinner from "@/Components/Spinner";

export default function ScheduleTab({ user }) {
    const [schedule, setSchedule] = useState({});
    const [loading, setLoading] = useState(true);
    const [scheduleInfo, setInfo] = useState("");

    useEffect(() => {
        getSchedule();
        getScheduleInfo();
    }, []);

    const getScheduleInfo = () => {
        axios
            .get(route("schedule.getInfo", { user: user.id }))
            .then((resp) => {
                setInfo(resp.data);
                setLoading(false);
            })
            .catch((Err) => toast.error(Err.response?.data?.message));
    };

    const getSchedule = () => {
        axios
            .get(route("schedule.get", { user: user.id }))
            .then((resp) => {
                setSchedule(resp.data);
                setLoading(false);
            })
            .catch((Err) => toast.error(Err.response?.data?.message));
    };

    return (
        <div className="mt-4">
            {loading && (
                <div className="my-3">
                    <Spinner />
                </div>
            )}

            {scheduleInfo !== "" && (
                <div className="bg-white rounded-lg px-3 py-4 shadow mb-5 text-gray-600 font-semibold dark:bg-zinc-900 dark:text-white">
                    {scheduleInfo}
                </div>
            )}

            {Object.keys(schedule).map((key, index) => {
                return (
                    <div
                        key={`schedule-${index}`}
                        className="flex  mb-5 md:items-center flex-col md:flex-row md:space-x-2 dark:text-gray-100 dark:bg-zinc-900 bg-white rounded-lg shadow p-3 text-gray-700 font-semibold"
                    >
                        <div className="md:w-24 md:text-sm mb-2 md:mb-0 text-gray-600 bg-gray-200 rounded-lg py-1.5 mr-2 text-center">
                            {schedule[key].day_name}
                        </div>

                        <div>
                            {`${schedule[key].from_hour || "--"}:${
                                schedule[key].from_minute || "--"
                            }`}
                            {schedule[key].from_hour &&
                                schedule[key].from_minute &&
                                schedule[key].from_type}
                        </div>

                        <div>
                            <VscArrowBoth />{" "}
                        </div>

                        <div>
                            {`${schedule[key].to_hour || "--"}:${
                                schedule[key].to_minute || "--"
                            }`}
                            {schedule[key].from_hour &&
                                schedule[key].from_minute &&
                                schedule[key].to_type}
                        </div>
                    </div>
                );
            })}
        </div>
    );
}
