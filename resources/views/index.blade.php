<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IndexedDB Example</title>
</head>
<body>
<form id="orderForm">
    @csrf
    <label for="customerName">Customer Name:</label>
    <input type="text" id="customerName" name="customerName" required><br>
    <label for="orderValue">Order Value:</label>
    <input type="number" id="orderValue" name="orderValue" required><br>
    <label for="orderDate">Order Date:</label>
    <input type="date" id="orderDate" name="orderDate" required><br>
    <button type="submit">Submit</button>
</form>

<h2>Orders</h2>
<table id="ordersTable" border="1">
    <thead>
    <tr>
        <th>Customer Name</th>
        <th>Order Value</th>
        <th>Order Date</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>

<script src="https://unpkg.com/dexie/dist/dexie.js"></script>
<script>
    // Create a new database
    const db = new Dexie('OrderDB');
    db.version(1).stores({
        orders: '++id,customerName,orderValue,orderDate'
    });

    // Form submission handler
    document.getElementById('orderForm').addEventListener('submit', async (event) => {
        event.preventDefault();
        const customerName = document.getElementById('customerName').value;
        const orderValue = document.getElementById('orderValue').value;
        const orderDate = document.getElementById('orderDate').value;

        // Save order to IndexedDB
        await db.orders.add({ customerName, orderValue, orderDate });
        loadOrders();
    });

    // Load orders and display in the table
    async function loadOrders() {
        const orders = await db.orders.toArray();
        const tbody = document.querySelector('#ordersTable tbody');
        tbody.innerHTML = '';
        orders.forEach(order => {
            const row = document.createElement('tr');
            row.innerHTML = `<td>${order.customerName}</td><td>${order.orderValue}</td><td>${order.orderDate}</td>`;
            tbody.appendChild(row);
        });
    }

    // Initial load of orders
    loadOrders();
</script>
</body>
</html>
