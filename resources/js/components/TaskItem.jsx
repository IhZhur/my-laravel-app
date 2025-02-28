import React from 'react';

const TaskItem = ({ task, onEdit, onDelete }) => {
    return (
        <li className="list-group-item d-flex justify-content-between align-items-center">
            <span>
                <strong>{task.title}</strong> - {task.description}
            </span>
            <span>
                {/* Отображение статуса задачи */}
                {task.completed ? (
                    <span className="badge bg-success me-2">Completed</span>
                ) : (
                    <span className="badge bg-warning text-dark me-2">Pending</span>
                )}

                {/* Кнопка редактирования */}
                <button
                    className="btn btn-sm btn-warning me-2"
                    onClick={onEdit}
                >
                    Edit
                </button>

                {/* Кнопка удаления */}
                <button
                    className="btn btn-sm btn-danger"
                    onClick={() => onDelete(task.id)}
                >
                    Delete
                </button>
            </span>
        </li>
    );
};

export default TaskItem;
