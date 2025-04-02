document.addEventListener("DOMContentLoaded", function() {
	const csrfToken = document
		.querySelector('meta[name="csrf-token"]')
		.getAttribute("content");

	// Görev Tamamlama
	document.querySelectorAll(".complete-task").forEach((button) => {
		button.addEventListener("click", async function() {
			let taskUuid = this.getAttribute("data-uuid");
	
			try {
				const response = await fetch(`/tasks/${taskUuid}/complete`, {
					method: "PATCH",
					headers: {
						"X-CSRF-TOKEN": csrfToken,
						"Content-Type": "application/json",
					},
				});
				const data = await response.json();
	
				if (data.success) {
					document.getElementById(`status-${taskUuid}`).innerText = "Tamamlandı";
					
					this.remove();
					
					let dueDateElement = document.querySelector(`#task-${taskUuid} .task-due_date`);
					if (dueDateElement) {
						// Sadece <span> içindeki etiketi kaldır
						dueDateElement.innerHTML = dueDateElement.innerText.split(" ")[0]; 
					}
				}
			} catch (error) {
				console.error("Hata:", error);
			}
		});
	});
	
	

	// Görev Silme
	document.querySelectorAll(".delete-task").forEach((button) => {
		button.addEventListener("click", async function() {
			let taskUuid = this.getAttribute("data-uuid");

			if (!confirm("Bu görevi silmek istediğinize emin misiniz?")) return;

			try {
				const response = await fetch(`/tasks/${taskUuid}`, {
					method: "DELETE",
					headers: {
						"X-CSRF-TOKEN": csrfToken,
						"Content-Type": "application/json",
					},
				});
				const data = await response.json();

				if (data.success) {
					document.getElementById(`task-${taskUuid}`).remove();
				}
			} catch (error) {
				console.error("Hata:", error);
			}
		});
	});

	// Görev Düzenleme
    document.querySelectorAll(".edit-task").forEach((button) => {
        button.addEventListener("click", function () {
            let taskUuid = this.getAttribute("data-uuid");
            let row = document.getElementById(`task-${taskUuid}`);

            let title = row.querySelector(".task-title").innerText;
            let description = row.querySelector(".task-description").innerText;
            let dueDate = row.querySelector(".task-due_date").dataset.date; 

            let priorityText = {
                Düşük: "low",
                Orta: "medium",
                Yüksek: "high",
            };
            let priority =
                priorityText[row.querySelector(".task-priority").innerText] || "low";

            document.getElementById("edit-task-uuid").value = taskUuid;
            document.getElementById("edit-title").value = title;
            document.getElementById("edit-description").value = description;
            document.getElementById("edit-priority").value = priority;
            document.getElementById("edit-due_date").value = dueDate;

            $("#editTaskModal").modal("show");
        });
    });

    // Düzenleme Formunu Gönderme
    const editTaskForm = document.getElementById("editTaskForm");
    if (editTaskForm) {
        editTaskForm.addEventListener("submit", async function (event) {
            event.preventDefault();

            let taskUuid = document.getElementById("edit-task-uuid").value;
            let formData = {
                title: document.getElementById("edit-title").value,
                description: document.getElementById("edit-description").value,
                priority: document.getElementById("edit-priority").value,
                due_date: document.getElementById("edit-due_date").value,
            };

            try {
                const response = await fetch(`/tasks/${taskUuid}`, {
                    method: "PUT",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(formData),
                });

                const data = await response.json();

                if (data.success) {
                    let row = document.getElementById(`task-${taskUuid}`);
                    row.querySelector(".task-title").innerText = formData.title;
                    row.querySelector(".task-description").innerText =
                        formData.description;

                    let priorityText = {
                        low: "Düşük",
                        medium: "Orta",
                        high: "Yüksek",
                    };

                    let priorityBadge = row.querySelector(".task-priority");
                    priorityBadge.innerHTML = `<span class="badge 
                        ${
                            formData.priority === "low"
                                ? "bg-success"
                                : formData.priority === "medium"
                                ? "bg-warning text-dark"
                                : "bg-danger"
                        } 
                        fs-6 fw-normal">
                        ${priorityText[formData.priority] || formData.priority}
                    </span>`;

                    let dueDateElement = row.querySelector(".task-due_date");
                    dueDateElement.dataset.date = formData.due_date; 
                    updateDueDateLabel(row, formData.due_date); 

                    $("#editTaskModal").modal("hide");
                }
            } catch (error) {
                console.error("Hata:", error);
            }
        });
    }

    function updateDueDateLabel(row, dueDate) {
        const dueDateElement = row.querySelector(".task-due_date");
        const taskDueDate = new Date(dueDate);
        const today = new Date();
        const daysLeft = Math.ceil((taskDueDate - today) / (1000 * 3600 * 24));

        const formattedDueDate = taskDueDate.toISOString().split("T")[0]; 

        let badge = "";
        if (daysLeft === 0) {
            badge = `<span class="badge bg-danger fs-7">Son Gün!</span>`;
        } else if (daysLeft === 1) {
            badge = `<span class="badge bg-warning fs-7 text-dark">Son 1 Gün</span>`;
        } else if (daysLeft === 2) {
            badge = `<span class="badge bg-warning fs-7 text-dark">Son 2 Gün</span>`;
        } else if (daysLeft === 3) {
            badge = `<span class="badge bg-info fs-7">Son 3 Gün</span>`;
        } 
		
        dueDateElement.innerHTML = `${formattedDueDate} ${badge}`;
    }
});