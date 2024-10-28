import Cookies from 'js-cookie'
import store from "../store";

const AuthenticatedLayout = () => import('../layouts/Authenticated.vue')
const GuestLayout = ()  => import('../layouts/Guest.vue');

const PostsIndex  = ()  => import('../views/admin/posts/Index.vue');
const PostsCreate  = ()  => import('../views/admin/posts/Create.vue');
const PostsEdit  = ()  => import('../views/admin/posts/Edit.vue');
const ExercisesIndex  = ()  => import('../views/admin/exercises/Index.vue');
const ExercisesCreate  = ()  => import('../views/admin/exercises/Create.vue');
const ExercisesEdit  = ()  => import('../views/admin/exercises/Edit.vue');

function requireLogin(to, from, next) {
    let isLogin = false;
    isLogin = !!store.state.auth.authenticated;

    if (isLogin) {
        next()
    } else {
        next('/login')
    }
}

function guest(to, from, next) {
    let isLogin;
    isLogin = !!store.state.auth.authenticated;

    if (isLogin) {
        next('/')
    } else {
        next()
    }
}

export default [
    {
        path: '/',
        // redirect: { name: 'login' },
        component: GuestLayout,
        children: [

            {
                path: '/',
                name: 'home',
                component: () => import('../views/home/index.vue'),
            },
            {
                path: 'posts',
                name: 'public-posts.index',
                component: () => import('../views/posts/index.vue'),
            },
            {
                path: 'posts/:id',
                name: 'public-posts.details',
                component: () => import('../views/posts/details.vue'),
            },
            {
                path: 'category/:id',
                name: 'category-posts.index',
                component: () => import('../views/category/posts.vue'),
            },
            {
                path: 'login',
                name: 'auth.login',
                component: () => import('../views/login/Login.vue'),
                beforeEnter: guest,
            },
            {
                path: 'register',
                name: 'auth.register',
                component: () => import('../views/register/index.vue'),
                beforeEnter: guest,
            },
            {
                path: 'forgot-password',
                name: 'auth.forgot-password',
                component: () => import('../views/auth/passwords/Email.vue'),
                beforeEnter: guest,
            },
            {
                path: 'reset-password/:token',
                name: 'auth.reset-password',
                component: () => import('../views/auth/passwords/Reset.vue'),
                beforeEnter: guest,
            },
        ]
    },
    {
        path: '/admin',
        component: AuthenticatedLayout,
        // redirect: {
        //     name: 'admin.index'
        // },
        beforeEnter: requireLogin,
        meta: { breadCrumb: 'Dashboard' },
        children: [
            {
                name: 'admin.index',
                path: '',
                component: () => import('../views/admin/index.vue'),
                meta: { breadCrumb: 'Admin' }
            },
            {
                name: 'profile.index',
                path: 'profile',
                component: () => import('../views/admin/profile/index.vue'),
                meta: { breadCrumb: 'Profile' }
            },
            {
                name: 'posts.index',
                path: 'posts',
                component: PostsIndex,
                meta: { breadCrumb: 'Posts' }
            },
            {
                name: 'posts.create',
                path: 'posts/create',
                component: PostsCreate,
                meta: { breadCrumb: 'Add new post' }
            },
            {
                name: 'posts.edit',
                path: 'posts/edit/:id',
                component: PostsEdit,
                meta: { breadCrumb: 'Edit post' }
            },
            {
                name: 'exercises',
                path: 'exercises',
                meta: { breadCrumb: 'Exercises'},
                children: [
                    {
                        name: 'exercises.index',
                        path: '',
                        component: ExercisesIndex,
                        meta: { breadCrumb: 'View' }
                    },
                    {
                        name: 'exercises.create',
                        path: 'create',
                        component: ExercisesCreate,
                        meta: { breadCrumb: 'Add new exercise' ,
                        linked: false, }
                    },
                    {
                        name: 'exercises.edit',
                        path: 'edit/:id',
                        component: ExercisesEdit,
                        meta: {
                            breadCrumb: 'Edit exercise',
                            linked: false,
                        }
                    }
                ]
            },

            {
                name: 'categories',
                path: 'categories',
                meta: { breadCrumb: 'Categories'},
                children: [
                    {
                        name: 'categories.index',
                        path: '',
                        component: () => import('../views/admin/categories/Index.vue'),
                        meta: { breadCrumb: 'View category' }
                    },
                    {
                        name: 'categories.create',
                        path: 'create',
                        component: () => import('../views/admin/categories/Create.vue'),
                        meta: {
                            breadCrumb: 'Add new category' ,
                            linked: false,
                        }
                    },
                    {
                        name: 'categories.edit',
                        path: 'edit/:id',
                        component: () => import('../views/admin/categories/Edit.vue'),
                        meta: {
                            breadCrumb: 'Edit category',
                            linked: false,
                        }
                    }
                ]
            },
            {
                //CREAR RUTA PARA TAREAS
                name: 'tasks',
                path: 'tasks',
                meta: { breadCrumb: 'Tareas'},
                children: [
                    {
                        name: 'task.index',
                        path: '',
                        component: () => import('../views/admin/tasks/index.vue'),
                        meta: { breadCrumb: 'Ver Tareas' }
                    },

                    {
                        name: 'task.create',
                        path: 'create',
                        component: () => import('../views/admin/tasks/Create.vue'),
                        meta: { breadCrumb: 'Nueva Tarea' }
                    }
                ]
            },
            {
                //CREAR RUTA PER CLIENTS

                name: 'clients',
                path:'clients',
                meta: { breadCrumb: 'Clients'},
                children: [
                    {
                        name: 'clients.index',
                        path: '',
                        component: () => import('../views/admin/clients/index.vue'),
                        meta: { breadCrumb: 'Llistat Clients' }
                    },
                    // {
                    //     name: 'clients.create',
                    //     path: 'create',
                    //     component: () => import('../views/admin/clients/create.vue'),
                    //     meta: { breadCrumb: 'Nou Client' }
                    // },
                    // {
                    //     name: 'clients.edit',
                    //     path: 'edit',
                    //     component: () => import('../views/admin/clients/edit.vue'),
                    //     meta: { breadCrumb: 'Gestió de clients' }
                    // }

                ]
            },


            {
                //CREAR RUTA PER PROVEIDORS

                name: 'proveidors',
                path:'proveidors',
                meta: { breadCrumb: 'Proveidors'},
                children: [
                    {
                        name: 'proveidors.index',
                        path: '',
                        component: () => import('../views/admin/proveidors/Index.vue'),
                        meta: { breadCrumb: 'Llistat Proveidors' }
                    },
                    {
                        name: 'proveidors.create',
                        path: 'create',
                        component: () => import('../views/admin/proveidors/Create.vue'),
                        meta: { breadCrumb: 'Nou Proveidor' }
                    },
                    //{
                      //  name: 'proveidors.edit',
                    // path: 'edit',
                    //  component: () => import('../views/admin/proveidors/Edit.vue'),
                      //  meta: { breadCrumb: 'Editar Proveidor' }
                    //}
                ]
            },
            {
                //CREAR RUTA PER MATERIALS

                name: 'materials',
                path:'materials',
                meta: { breadCrumb: 'Materials'},
                children: [
                    {
                        name: 'materials.index',
                        path: '',
                        component: () => import('../views/admin/materials/Index.vue'),
                        meta: { breadCrumb: 'Llistat Materials' }
                    },
                    {
                        name: 'materials.create',
                        path: 'create',
                        component: () => import('../views/admin/materials/Create.vue'),
                        meta: { breadCrumb: 'Nou Material' }
                    },
                   // {
                     //   name: 'materials.edit',
                       // path: 'edit',
                        //component: () => import('../views/admin/materials/Edit.vue'),
                        //meta: { breadCrumb: 'Editar Material' }
                    //}
                ]
            },
            //CREAR RUTA PER A ODRES DE TREBALL
            {
                name: 'ordre.treball',
                path: 'ordretreballs',
                meta: { breadCrumb: 'Ordre Treball' },
                children: [
                    {
                        name: 'ordreTreballs.index',
                        path: '',
                        component: () => import('../views/admin/ordreTreballs/Index.vue'),
                        meta: { breadCrumb: 'Ordres Treball Actives' }
                    },
                    {
                        name: 'ordreTreballs.print',
                        path: '',
                        component: () => import('../views/admin/ordreTreballs/print.vue'),
                        meta: { breadCrumb: 'Ordres Treball Actives' }
                    },
                ]
            },
            {
                //CREAR RUTA PER ALBARANS

                name: 'albarans',
                path:'albarans',
                meta: { breadCrumb: 'albarans'},
                children: [
                    {
                        name: 'albarans.index',
                        path: '',
                        component: () => import('../views/admin/Albarans/Index.vue'),
                        meta: { breadCrumb: 'Llistat Albarans' }
                    },
                    {
                        name: 'albarans.create',
                        path: 'create',
                        component: () => import('../views/admin/Albarans/Create.vue'),
                        meta: { breadCrumb: 'Nou Albaran' }
                    },
                    //{
                      //  name: 'albarans.edit',
                        //path: 'edit',
                        //component: () => import('../views/admin/Albarans/Edit.vue'),
                        //meta: { breadCrumb: 'Editar Albaran' }
                    //}
                ]
            },
            {
                name: 'permissions',
                path: 'permissions',
                meta: { breadCrumb: 'Permisos'},
                children: [
                    {
                        name: 'permissions.index',
                        path: '',
                        component: () => import('../views/admin/permissions/Index.vue'),
                        meta: { breadCrumb: 'Permissions' }
                    },
                    {
                        name: 'permissions.create',
                        path: 'create',
                        component: () => import('../views/admin/permissions/Create.vue'),
                        meta: {
                            breadCrumb: 'Create Permission',
                            linked: false,
                        }
                    },
                    {
                        name: 'permissions.edit',
                        path: 'edit/:id',
                        component: () => import('../views/admin/permissions/Edit.vue'),
                        meta: {
                            breadCrumb: 'Permission Edit',
                            linked: false,
                        }
                    }
                ]
            },

            //TODO Organizar rutas
            {
                name: 'roles.index',
                path: 'roles',
                component: () => import('../views/admin/roles/Index.vue'),
                meta: { breadCrumb: 'Rols' }
            },
            {
                name: 'roles.create',
                path: 'roles/create',
                component: () => import('../views/admin/roles/Create.vue'),
                meta: { breadCrumb: 'Crear Rol' }
            },
            {
                name: 'roles.edit',
                path: 'roles/edit-:id',//canvio la ruta amb un guió (edit-) pq no ens deixi accdeir amb el breadcrumb
                component: () => import('../views/admin/roles/Edit.vue'),
                meta: { breadCrumb: 'Editar Rol' }
            },
            {
                name: 'users.index',
                path: 'users',
                component: () => import('../views/admin/users/Index.vue'),
                meta: { breadCrumb: 'Usuaris' }
            },
            {
                name: 'users.create',
                path: 'users/create',
                component: () => import('../views/admin/users/Create.vue'),
                meta: { breadCrumb: 'Nou usuari' }
            },
            {
                name: 'users.edit',
                path: 'users/edit-:id',//canvio la ruta amb un guió (edit-) pq no ens dix accdeir amb el breadcrumb
                component: () => import('../views/admin/users/Edit.vue'),
                meta: { breadCrumb: 'Editar Usuari',}
            },
        ]
    },
    {
        path: "/:pathMatch(.*)*",
        name: 'NotFound',
        component: () => import("../views/errors/404.vue"),
    },
];
