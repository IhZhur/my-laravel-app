import React, { useState, useEffect } from 'react';
import TaskItem from './TaskItem';

const TaskList = () => {
    const [tasks, setTasks] = useState([]);
    const [error, setError] = useState(null); // Для отображения ошибок

    useEffect(() => {
        fetch('/api/tasks')
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Failed to fetch tasks');
                }
                return response.json();
            })
            .then((data) => {
                // Проверяем, является ли data массивом
                if (Array.isArray(data)) {
                    setTasks(data);
                } else {
                    console.error('API did not return an array');
                    setTasks([]); // Устанавливаем пустой массив
                }
            })
            .catch((error) => {
                console.error('Error fetching tasks:', error);
                setError(error.message); // Сохраняем сообщение об ошибке
            });
    }, []);

    if (error) {
        return <div className="alert alert-danger">Error: {error}</div>;
    }

    return (
        <div>
            <h2>Task List</h2>
            {tasks.length === 0 ? (
                <p>No tasks available.</p>
            ) : (
                <ul className="list-group">
                    {tasks.map((task) => (
                        <TaskItem key={task.id} task={task} />
                    ))}
                </ul>
            )}
        </div>
    );
};

export default TaskList;
