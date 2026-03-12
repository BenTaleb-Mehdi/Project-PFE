# 🛠️ Services Documentation

This document explains the architecture and logic of the core services implemented in the project. These services encapsulate the business logic, ensuring a clean separation from controllers and models.

---

## 🏗️ Core Services Overview

### 1. [CategoryService](file:///c:/Solicode/PFE-Project-26/Project-PFE/PFE-Project/app/Services/CategoryService.php)
Manages the categories of meals available in the system.
- **Functions:** CRUD operations for `MealCategory`.
- **Special Logic:** Prevents the deletion of a category if it is currently linked to any existing `Meal` records to maintain referential integrity.

### 2. [ClientRegistryService](file:///c:/Solicode/PFE-Project-26/Project-PFE/PFE-Project/app/Services/ClientRegistryService.php)
Handles detailed client information and health metrics.
- **Detailed Registry:** Retrieves clients with their associated user data and evolution history, supporting searching by name.
- **Biometric Calculations:** 
    - **BMI:** Calculated using the latest weight from `Evolution` and the client's static height.
    - **Weight Trend:** Compares the two most recent weight entries to determine the gain or loss.
- **Optimization:** Automatically sorts evolutions by `recorded_at` to ensure accuracy regardless of data entry order.

### 3. [DashboardService](file:///c:/Solicode/PFE-Project-26/Project-PFE/PFE-Project/app/Services/DashboardService.php)
Aggregates high-level metrics for the administrator/coach dashboard.
- **Revenue:** Sums all `completed` payments.
- **Active Pupils:** Counts clients with an `active` status.
- **System Stream:** Retrieves the most recent clients added to the system for real-time monitoring.

### 4. [NutritionService](file:///c:/Solicode/PFE-Project-26/Project-PFE/PFE-Project/app/Services/NutritionService.php)
Handles the meal planning and protocol logic.
- **Meal Registration:** Adds meals to a program while automatically calculating total calories based on macronutrients (Protein: 4 kcal, Carbs: 4 kcal, Fat: 9 kcal).
- **Protocol Finalization:** Formally closes a program, ensuring all items are saved within a database transaction for safety.

### 5. [StrategicControlService](file:///c:/Solicode/PFE-Project-26/Project-PFE/PFE-Project/app/Services/StrategicControlService.php)
Provides administrative and financial oversight.
- **Team Manifest:** Lists all staff members with a count of their assigned clients.
- **Financial Flows:** Provides paginated transaction logs for payments, supporting status-based filtering (e.g., `completed`, `pending`).

---

## ✅ Best Practices Applied
1. **Single Responsibility:** Each service focuses on a specific domain.
2. **Database Transactions:** Used in `NutritionService` to ensure data consistency during complex updates.
3. **Convention over Configuration:** Standardized model names (e.g., `Client` and `Staff`) to align with Laravel performance and autoloading standards.
4. **Data Integrity:** Strict checks (like in `CategoryService`) prevent accidental orphan records.
