document.addEventListener("DOMContentLoaded", function () {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    // Görev Tamamlama
    document.querySelectorAll(".complete-task").forEach((button) => {
        button.addEventListener("click", async function () {
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
                    document.getElementById(`status-${taskUuid}`).innerText =
                        "Tamamlandı";
                    this.remove();
                }
            } catch (error) {
                console.error("Hata:", error);
            }
        });
    });

    // Görev Silme
    document.querySelectorAll(".delete-task").forEach((button) => {
        button.addEventListener("click", async function () {
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

            // Güncellenmiş değerleri çek
            let title = row.querySelector(".task-title").innerText;
            let description = row.querySelector(".task-description").innerText;
            let dueDate = row.querySelector(".task-due_date").innerText;

            let priorityText = {
                Düşük: "low",
                Orta: "medium",
                Yüksek: "high",
            };
            let priority =
                priorityText[row.querySelector(".task-priority").innerText] ||
                "low";

            // Modal içindeki inputları güncelleme
            document.getElementById("edit-task-uuid").value = taskUuid;
            document.getElementById("edit-title").value = title;
            document.getElementById("edit-description").value = description;
            document.getElementById("edit-priority").value = priority;
            document.getElementById("edit-due_date").value = dueDate;

            $("#editTaskModal").modal("show");
        });
    });

    // Düzenleme Formunu Gönderme
    document
        .getElementById("editTaskForm")
        .addEventListener("submit", async function (event) {
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

                    // Öncelik değerlerini Türkçeye çevirme
                    let priorityText = {
                        low: "Düşük",
                        medium: "Orta",
                        high: "Yüksek",
                    };
                    row.querySelector(".task-priority").innerText =
                        priorityText[formData.priority] || formData.priority;

                    row.querySelector(".task-due_date").innerText =
                        formData.due_date;

                    $("#editTaskModal").modal("hide");
                }
            } catch (error) {
                console.error("Hata:", error);
            }
        });
});
