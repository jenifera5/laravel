<template>
    <div class="row justify-content-center my-5">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form @submit.prevent="submitForm">
                        <div class="mb-3">
                            <label for="post-title" class="form-label">Nom </label>
                            <input v-model="post.name" id="post-title" type="text" class="form-control">
                            <div class="text-danger mt-1">
                                {{ errors.name }}
                            </div>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.name">
                                    {{ message }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="post-apellido" class="form-label"> Cognom </label>
                            <input v-model="post.apellido" id="post-title" type="text" class="form-control">
                            <div class="text-danger mt-1">
                                {{ errors.apellido }}
                            </div>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.apellido">
                                    {{ message }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="post-dni" class="form-label"> Dni </label>
                            <input v-model="post.dni" id="post-title" type="text" class="form-control">
                            <div class="text-danger mt-1">
                                {{ errors.dni }}
                            </div>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.dni">
                                    {{ message }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="post-direccion" class="form-label"> Direcció </label>
                            <input v-model="post.direccion" id="post-title" type="text" class="form-control">
                            <div class="text-danger mt-1">
                                {{ errors.direccion }}
                            </div>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.direccion">
                                    {{ message }}
                                </div>
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="emailreset" class="form-label">Email</label>
                            <input v-model="post.email" id="emailreset"  type="email" class="form-control">
                            <div class="text-danger mt-1">
                                {{ errors.email }}
                            </div>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.email">
                                    {{ message }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input v-model="post.password" id="password" type="password" class="form-control">
                            <div class="text-danger mt-1">
                                {{ errors.password }}
                            </div>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.password">
                                    {{ message }}
                                </div>
                            </div>
                        </div>
                        <!-- Role -->
                        <div class="mb-3">
                            <label for="post-category" class="form-label">
                                Rol
                            </label>
                            <v-select multiple v-model="post.role_id" :options="roleList" :reduce="role => role.id" label="name" class="form-control" />
                            <div class="text-danger mt-1">
                                {{ errors.role_id }}
                            </div>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.role_id">
                                    {{ message }}
                                </div>
                            </div>
                        </div>
                        <!-- Buttons -->
                        <div class="mt-4">
                            <button :disabled="isLoading" class="btn btn-primary">
                                <div v-show="isLoading" class=""></div>
                                <span v-if="isLoading">Processant...</span>
                                <span v-else>Guardar</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
    import { onMounted, reactive } from "vue";
    import useRoles from "@/composables/roles";
    import useUsers from "@/composables/users";

    const { roleList, getRoleList } = useRoles();
    const { storeUser, validationErrors, isLoading } = useUsers();

    import { useForm, useField, defineRule } from "vee-validate";
    import { required, min } from "@/validation/rules";
    defineRule('required', required);
    defineRule('min', min);

    // Define a validation schema
    const schema = {
        name: 'required',
        email: 'required',
        password: 'required|min:8',
    }
    // Create a form context with the validation schema
    const { validate, errors } = useForm({ validationSchema: schema })
    // Define actual fields for validation
    const { value: name } = useField('name', null, { initialValue: '' });
    const { value: email } = useField('email', null, { initialValue: '' });
    const { value: password } = useField('password', null, { initialValue: '' });
    const { value: role_id } = useField('role_id', null, { initialValue: '', label: 'role' });

    const post = reactive({
        name,
        email,
        password,
        role_id,
    })
    function submitForm() {
        validate().then(form => { if (form.valid) storeUser(post) })
    }
    onMounted(() => {
        getRoleList()
    })
</script>
