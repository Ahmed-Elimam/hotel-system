import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

export function useAuth() {
    const user = computed(() => usePage().props.auth?.user);

    const hasRole = (role) => {
        return user.value?.roles.includes(role);
    };

    return { user, hasRole };
}
