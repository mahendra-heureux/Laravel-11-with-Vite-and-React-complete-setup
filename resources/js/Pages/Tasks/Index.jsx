import React from 'react';
import { Head,Link,useForm } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import axios from 'axios';

const Index = ({ tasks }) => {
    console.log("tasks", tasks);
    const { delete: deleteTask } = useForm();

    const handleDelete = (id) => {
        if (confirm("Are you sure you want to delete this task?")) {
            deleteTask(`/tasks/${id}`, {
                onSuccess: () => {
                    console.log("Task deleted successfully");
                },
                onError: (errors) => {
                    console.error("Failed to delete task:", errors);
                },
            });
        }
    };

    return (
        <AuthenticatedLayout
        header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Tasks</h2>}
    >
        <Head title="Tasks" />
        <div>
        <h1 className="tasks-heading">Tasks</h1>
        <Link href="/tasks/create" className="create-task-button">Create New Task</Link>
        <a href='/tasksreport' className="create-task-button" target='_blank'>Export Report</a>
            <div className="task-table-container">
    <table className="task-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Due Date</th>
                <th>Assigned to</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {tasks.map(task => (
                <tr key={task.id}>
                    <td>{task.title}</td>
                    <td>{task.description}</td>
                    <td>{task.due_date}</td>
                    <td>{task.user.name}</td>
                    <td>
                        <a href={`/tasks/${task.id}/edit`}>Edit</a> | &nbsp;
                        <button onClick={() => handleDelete(task.id)}>Delete</button>
                    </td>
                </tr>
            ))}
        </tbody>
    </table>
</div>

        </div>
        </AuthenticatedLayout>
    );
};

export default Index;
