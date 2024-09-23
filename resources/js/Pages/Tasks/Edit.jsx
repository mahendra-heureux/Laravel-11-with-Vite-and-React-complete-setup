import React, { useState } from 'react';
import { Head, usePage } from '@inertiajs/react';
import axios from "axios";
import PrimaryButton from '@/Components/PrimaryButton';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

const Edit = ({ task }) => {
    const [title, setTitle] = useState(task.title);
    const [description, setDescription] = useState(task.description);
    const [due_date, setDueDate] = useState(task.due_date);
    const user = usePage().props.auth.user;
    const handleSubmit = (e) => {
        e.preventDefault();
        axios.patch(`/tasks/${task.id}`, { title, description, due_date, assigned_user:user.id  });
    };

    return (
        <AuthenticatedLayout
        header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Edit Task</h2>}
    >
        <Head title="Edit Task" />
            <form onSubmit={handleSubmit}>
                <div>
                    <label>Title</label>
                    <input
                        type="text"
                        value={title}
                        onChange={(e) => setTitle(e.target.value)}
                        required
                    />
                </div>
                <div>
                    <label>Description</label>
                    <textarea
                        value={description}
                        onChange={(e) => setDescription(e.target.value)}
                    />
                </div>
                <div>
                    <label>Due Date</label>
                    <input
                        type="date"
                        value={due_date}
                        onChange={(e) => setDueDate(e.target.value)}
                    />
                </div>
                <PrimaryButton type="submit">Update</PrimaryButton>
            </form>
        </AuthenticatedLayout>
    );
};

export default Edit;
