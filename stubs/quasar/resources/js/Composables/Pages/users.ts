
export const useUsers = () => {

    const fabBtn = [
        { color: "primary", icon: "email", label: "Email", onClick : () => {
            console.log('email clicked')
        }},
        { color: "secondary", icon: "alarm", label: "Alarm" },
        { color: "orange", icon: "airplay", label: "airplay" },
        { color: "accent", icon: "room", label: "Map" },
        { color: "accent", icon: "home", label: "home", to: "/" },
    ];

    const columns = [
        {
            name: "name",
            required: true,
            label: "Dessert (100g serving)",
            align: "left",
            field: "name",
            format: (val: any) => `${val}`,
            sortable: true,
        },
        {
            name: "email",
            align: "center",
            label: "Calories",
            field: "email",
            sortable: true,
        },
        {
            name: "account",
            label: "account label",
            field: "account",
            sortable: true,
        },
        { name: "role", label: "role (g)", field: "role", sortable: true },
        { name: "phone", label: "phone (g)", field: "phone", sortable: true },
    ];

    return {fabBtn, columns}
}
