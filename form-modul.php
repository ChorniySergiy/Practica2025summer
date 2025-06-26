<?php 
?>
<!DOCTYPE html>
<head>
    <style>
        .body-form {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .h2-form {
            color: #343a40;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #dee2e6;
        }
        th {
            background-color: #343a40;
        }
        textarea {
            width: 100%;
            resize: vertical;
        }
        button {
            padding: 8px 16px;
            margin-right: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body class="body-form">
<h2 class="h2-form">Оновлення модулів Magefan</h2>
<div id="form-container">
    <table id="module-table" border="1" cellpadding="5">
        <thead>
        <tr>
            <th>Модуль</th>
            <th>Що нового</th>
            <th>Дія</th>
        </tr>
        </thead>
        <tbody id="table-body">
        <!-- Рядки форми тут -->
        </tbody>
    </table>
    <button onclick="addRow()">Додати новий</button>
    <button onclick="updateOutput()">Оновити</button>
</div>

<br>
<textarea id="result" rows="10" placeholder="HTML буде тут..."></textarea>
<br>
<button onclick="copyResult()">Копіювати код</button>

<script>
    const modules = [
        "Blog", "Facebook Pixel", "Google Tag Manager", "Login As Customer",
        "Hreflang Tags", "Translation", "Cron Scheduler", "Dynamic Category",
        "Page Speed Optimizer", "Product Tabs", "WebP Images", "Rich Snippets",
        "Zero Downtime Deployment", "Multi Blog", "Better Sorting", "Extended Sitemap"
    ];

    function addRow() {
        const tbody = document.getElementById('table-body');
        const tr = document.createElement('tr');

        const selectTd = document.createElement('td');
        const select = document.createElement('select');
        modules.forEach(mod => {
            const option = document.createElement('option');
            option.value = mod;
            option.textContent = mod;
            select.appendChild(option);
        });
        selectTd.appendChild(select);

        const textareaTd = document.createElement('td');
        const textarea = document.createElement('textarea');
        textarea.rows = 2;
        textareaTd.appendChild(textarea);

        const actionTd = document.createElement('td');
        const delBtn = document.createElement('button');
        delBtn.textContent = 'Видалити';
        delBtn.onclick = () => tr.remove();
        actionTd.appendChild(delBtn);

        tr.appendChild(selectTd);
        tr.appendChild(textareaTd);
        tr.appendChild(actionTd);
        tbody.appendChild(tr);
    }

    function updateOutput() {
        const textareaList = document.querySelectorAll('#table-body textarea');
        const selectList = document.querySelectorAll('#table-body select');
        let htmlEditorCode = document.querySelector('code-input textarea')?.value.trim() ?? '';

        let parser = new DOMParser();
        let doc = parser.parseFromString(htmlEditorCode, 'text/html');
        let message = '';

        for (let i = 0; i < textareaList.length; i++) {
            const module = selectList[i].value.trim();
            const text = textareaList[i].value.trim();
            if (!text) continue;

            const links = [...doc.querySelectorAll('a')];
            const targetLink = links.find(link => link.textContent.trim() === module);

            if (targetLink) {
                const mainTable = targetLink.closest('table');

                if (mainTable) {
                    // Шукаємо сусідній блок Content
                    const blockContentRow = mainTable.parentElement?.parentElement?.nextElementSibling;
                    const blockContentTable = blockContentRow?.querySelector('table tbody');

                    if (blockContentTable) {
                        // Додаємо нові рядки в кінець Block Content
                        const newRows = text.split('\n').map(line => {
                            const tr = doc.createElement('tr');
                            tr.innerHTML = `
                                <td style="vertical-align: top; padding-right: 10px;">
                                    <img src="https://ma5.magefan.com/media/images/NewDesign24/Icons/mark.png" />
                                </td>
                                <td style="padding-bottom: 12px;">
                                    <span style="color:red">${line}</span>
                                </td>
                            `;
                            return tr;
                        });

                        newRows.forEach(row => blockContentTable.appendChild(row));
                    } else {
                        message += `Block Content для модуля "${module}" не знайдено!\n`;
                    }
                }
            } else {
                message += `Модуль "${module}" не знайдено!\n`;
            }
        }

        const resultHTML = doc.body.innerHTML;
        document.getElementById('result').value = resultHTML;
        document.getElementById("output").contentDocument.body.insertAdjacentHTML("beforeend", result);

        if (message) alert(message);
    }

    function copyResult() {
    const textarea = document.getElementById("result");
    textarea.select();
    textarea.setSelectionRange(0, 99999); // для мобільних
    document.execCommand("copy");

    // Краще: використати Clipboard API, якщо підтримується
    if (navigator.clipboard) {
        navigator.clipboard.writeText(textarea.value).then(() => {
            alert("Код скопійовано!");
        }).catch(err => {
            alert("Помилка при копіюванні: " + err);
        });
    } else {
        alert("Код скопійовано!");
    }
}

</script>
</body>
</html>

