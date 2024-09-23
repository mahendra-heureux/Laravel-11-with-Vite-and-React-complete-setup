import React, { useState } from 'react';
import { Head, usePage ,useForm} from '@inertiajs/react';
import axios from "axios";
import PrimaryButton from '@/Components/PrimaryButton';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import 'react-toastify/dist/ReactToastify.css';
import { Inertia } from '@inertiajs/inertia'; // Import Inertia
import { toast, ToastContainer } from 'react-toastify';


const Create = () => {
    const user = usePage().props.auth.user;
    const [title, setTitle] = useState('');
    const [description, setDescription] = useState('');
    const [due_date, setDueDate] = useState('');
    // Access both the authenticated user and the list of users
    const { auth, users } = usePage().props;
    console.log(usePage().props);
    const { data, setData, post, processing, errors, reset } = useForm({
        title: '',
        description: '',
        due_date: '',
        assigned_user: auth.user.id,
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('tasks.store'));
    };


    // const handleSubmit = async(e) => {
    //     e.preventDefault();
    //     let response = await axios.post('/tasks', { title, description, due_date, assigned_user: user.id });
    //     if (response?.data?.error == false) {   
    //         toast.success(response.data.message);
    //         Inertia.visit('/tasks'); // Navigate to the tasks page

    //     } else {
    //         toast.error("Something Went Wrong!");
    //     }
    // };

    return (
        <AuthenticatedLayout
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Create New Task</h2>}
        >
            <Head title="Create New Task" />
            <h1>Create New Task</h1>
            <form onSubmit={submit}>
                <div>
                    <label>Title</label>
                    <input
                        type="text"
                        value={data.title}
                        required
                        onChange={(e) => setData('title', e.target.value)}

                    />
                </div>
                <div>
                    <label>Description</label>
                    <textarea
                        value={data.description}
                        onChange={(e) => setData('description', e.target.value)}

                    />
                </div>
                <div>
                    <label>Assigned To</label>
                    <select
                        value={data.assigned_user}
                        onChange={(e) => setData('assigned_user', e.target.value)}
                    >
                        {/* Map over the list of users to populate the dropdown */}
                        {users.map((user) => (
                            <option key={user.id} value={user.id}>
                                {user.name}
                            </option>
                        ))}
                    </select>
                </div>
                <div>
                    <label>Due Date</label>
                    <input
                        type="date"
                        value={data.due_date}
                        onChange={(e) => setData('due_date', e.target.value)}

                    />
                </div>
                <PrimaryButton type="submit">Create</PrimaryButton>
            </form>
            <ToastContainer />
        </AuthenticatedLayout>
    );
};

export default Create;
