<script setup lang="ts">
import HomeLayout from '@/Layouts/HomeLayout.vue';
import deepGet from '@/utils/deep-get';
import deepDiff from '@/utils/object-diff';
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import gsap from 'gsap';
import { onMounted, ref } from 'vue';

const props = usePage().props;
const user = props.auth.user;

const initialFormData = {
    name: user.name,
    email: user.email,
    profile: {
        date_of_birth: user.profile?.date_of_birth || '',
        gender: user.profile?.gender!,
        phone: user.profile?.phone || '',
        profile_image: user.profile?.profile_image?.url,
    },
};

const userForm = useForm<{
    name: string;
    email: string;
    profile: {
        date_of_birth: string;
        gender: App.enums.GenderEnums;
        profile_image: File | null | string | undefined;
        phone: string;
    };
}>({
    name: user.name,
    email: user.email,
    profile: {
        date_of_birth: user.profile?.date_of_birth || '',
        gender: user.profile?.gender!,
        profile_image: user.profile?.profile_image?.url,
        phone: user.profile?.phone || '',
    },
});

const passwordForm = useForm({
    current_password: '',
    new_password: '',
    new_password_confirmation: '',
});

// State for UI control
const isEditing = ref(false);
const isChangingPassword = ref(false);
const fileInput = ref<HTMLInputElement | null>(null);

const previewImage = ref<string | null>(
    user.profile?.profile_image?.url ?? null,
);
// Handle image selection
const handleImageSelect = () => {
    fileInput.value?.click();
};

const onFileChange = (event: Event) => {
    const input = event.target as HTMLInputElement;
    userForm.profile.profile_image = input.files![0];
    const reader = new FileReader();
    reader.onload = (e) => {
        previewImage.value = e.target?.result as string;
    };
    reader.readAsDataURL(userForm.profile.profile_image);
};

// Form submission handlers
const updateProfile = () => {
    const currentData = userForm.data();
    const changes = deepDiff(initialFormData, currentData);
    userForm
        .transform(() => ({ ...changes, _method: 'patch' }))
        .post(route('profile.update'), {
            onBefore: (params) => {
                // console.log(params.data);
            },
            onSuccess: () => {
                isEditing.value = false;
                showToast('Profile updated successfully!');
            },
            onError: (err) => {
                showToast(Object.values(err).flat()[0]);
            },
        });
};
const updatePassword = () => {
    passwordForm.patch(route('profile.update'), {
        onSuccess: () => {
            isChangingPassword.value = false;
            passwordForm.reset();
            showToast('Password updated successfully!');
        },
    });
};

const cancelEdit = () => {
    userForm.reset();
    isEditing.value = false;
};
// Simple toast notification
const toastVisible = ref(false);
const toastMessage = ref('');

const showToast = (message: string) => {
    toastMessage.value = message;
    toastVisible.value = true;
    setTimeout(() => {
        toastVisible.value = false;
    }, 3000);
};

// GSAP animations
onMounted(() => {
    // Animate profile card on page load
    gsap.from('.profile-card', {
        y: 20,
        opacity: 0,
        duration: 0.8,
        ease: 'power3.out',
    });

    // Stagger form fields animation
    gsap.from('.form-field', {
        y: 15,
        opacity: 0,
        stagger: 0.1,
        duration: 0.6,
        delay: 0.3,
        ease: 'power2.out',
    });
});

defineOptions({
    layout: HomeLayout,
});
</script>

<template>
    <Head title="Edit Profile"></Head>

    <!-- Toast notification -->
    <div class="toast toast-center toast-middle z-50" v-if="toastVisible">
        <div class="alert alert-success">
            <span>{{ toastMessage }}</span>
        </div>
    </div>

    <div class="mx-auto max-w-4xl p-4">
        <!-- Main profile card -->
        <div class="profile-card card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <h1 class="card-title mb-6 text-3xl font-bold">
                        Edit Profile
                    </h1>
                    <button
                        class="btn btn-sm btn-ghost btn-link"
                        @click="router.post(route('logout'))"
                    >
                        Log Out
                    </button>
                </div>

                <form @submit.prevent="updateProfile">
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                        <!-- Profile image section -->
                        <div class="flex flex-col items-center space-y-4">
                            <div class="avatar" v-if="previewImage">
                                <div
                                    class="ring-primary ring-offset-base-100 relative h-48 w-48 overflow-hidden rounded-full ring ring-offset-2"
                                >
                                    <img
                                        :src="previewImage"
                                        alt="Profile image"
                                        class="h-full w-full object-cover"
                                    />
                                    <div
                                        class="bg-opacity-0 hover:bg-opacity-40 absolute inset-0 flex items-center justify-center transition-all duration-300"
                                    >
                                        <button
                                            @click="handleImageSelect"
                                            class="btn btn-circle btn-ghost text-white opacity-0 hover:opacity-100"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-6 w-6"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div
                                v-if="!previewImage"
                                class="avatar avatar-placeholder"
                            >
                                <div
                                    class="bg-base-200 text-base-content h-48 w-48 rounded-full"
                                >
                                    <span class="p-3 text-3xl">
                                        {{ user.name[0] }}
                                    </span>
                                </div>
                                <div
                                    class="bg-opacity-0 hover:bg-opacity-40 absolute inset-0 flex items-center justify-center transition-all duration-300"
                                >
                                    <button
                                        @click="handleImageSelect"
                                        class="btn btn-circle btn-ghost text-white opacity-0 hover:opacity-100"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-6 w-6"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <input
                                type="file"
                                ref="fileInput"
                                @change="onFileChange"
                                accept="image/*"
                                class="hidden"
                            />
                            <button
                                type="button"
                                @click="handleImageSelect"
                                class="btn btn-primary btn-sm"
                            >
                                Change Photo
                            </button>
                        </div>
                        <!-- Profile details form -->
                        <div class="col-span-2">
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div class="form-field form-control w-full">
                                    <label class="label">
                                        <span class="label-text">Name</span>
                                    </label>
                                    <input
                                        v-model="userForm.name"
                                        type="text"
                                        placeholder="Your name"
                                        class="input w-full focus-within:outline-none"
                                        :class="{
                                            'input-error': userForm.errors.name,
                                        }"
                                    />
                                    <label
                                        v-if="userForm.errors.name"
                                        class="label"
                                    >
                                        <span
                                            class="label-text-alt text-error"
                                            >{{ userForm.errors.name }}</span
                                        >
                                    </label>
                                </div>
                                <div class="form-field form-control w-full">
                                    <label class="label">
                                        <span class="label-text">Email</span>
                                    </label>
                                    <input
                                        v-model="userForm.email"
                                        type="email"
                                        placeholder="Your email"
                                        class="input w-full focus-within:outline-none"
                                        :class="{
                                            'input-error':
                                                userForm.errors.email,
                                        }"
                                    />
                                    <label
                                        v-if="userForm.errors.email"
                                        class="label"
                                    >
                                        <span
                                            class="label-text-alt text-error"
                                            >{{ userForm.errors.email }}</span
                                        >
                                    </label>
                                </div>
                                <div class="form-field form-control w-full">
                                    <label class="label">
                                        <span class="label-text">Phone</span>
                                    </label>
                                    <input
                                        v-model="userForm.profile.phone"
                                        type="tel"
                                        placeholder="Your phone number"
                                        class="input w-full focus-within:outline-none"
                                        :class="{
                                            'input-error': deepGet(
                                                userForm.errors,
                                                'profile.phone',
                                                false,
                                            ),
                                        }"
                                    />
                                    <label
                                        v-if="
                                            deepGet(
                                                userForm.errors,
                                                'profile.phone',
                                                false,
                                            )
                                        "
                                        class="label"
                                    >
                                        <span class="label-text-alt text-error">
                                            {{
                                                deepGet(
                                                    userForm.errors,
                                                    'profile.phone',
                                                    false,
                                                )
                                            }}
                                        </span>
                                    </label>
                                </div>
                                <div class="form-field form-control w-full">
                                    <label class="label">
                                        <span class="label-text"
                                            >Date of Birth</span
                                        >
                                    </label>
                                    <input
                                        v-model="userForm.profile.date_of_birth"
                                        type="date"
                                        class="input w-full focus-within:outline-none"
                                        :class="{
                                            'input-error': deepGet(
                                                userForm.errors,
                                                'profile.date_of_birth',
                                                false,
                                            ),
                                        }"
                                    />
                                    <label
                                        v-if="
                                            deepGet(
                                                userForm.errors,
                                                'profile.date_of_birth',
                                                false,
                                            )
                                        "
                                        class="label"
                                    >
                                        <span
                                            class="label-text-alt text-error"
                                            >{{
                                                deepGet(
                                                    userForm.errors,
                                                    'profile.date_of_birth',
                                                    false,
                                                )
                                            }}</span
                                        >
                                    </label>
                                </div>
                                <div class="form-field form-control w-full">
                                    <label class="label">
                                        <span class="label-text">Gender</span>
                                    </label>
                                    <select
                                        v-model="userForm.profile.gender"
                                        class="select w-full focus-within:outline-none"
                                        :class="{
                                            'select-error': deepGet(
                                                userForm.errors,
                                                'profile.gender',
                                                false,
                                            ),
                                        }"
                                    >
                                        <option value="" disabled>
                                            Select gender
                                        </option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                        <option value="unknown">
                                            Prefer not to say
                                        </option>
                                    </select>
                                    <label
                                        v-if="
                                            deepGet(
                                                userForm.errors,
                                                'profile.gender',
                                                false,
                                            )
                                        "
                                        class="label"
                                    >
                                        <span
                                            class="label-text-alt text-error"
                                            >{{
                                                deepGet(
                                                    userForm.errors,
                                                    'profile.gender',
                                                    false,
                                                )
                                            }}</span
                                        >
                                    </label>
                                </div>
                            </div>
                            <!-- Profile update action buttons -->
                            <div
                                class="form-field mt-6 flex justify-end space-x-2"
                            >
                                <button
                                    v-if="userForm.isDirty"
                                    @click="cancelEdit"
                                    class="btn btn-outline"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    :disabled="
                                        userForm.processing || !userForm.isDirty
                                    "
                                >
                                    <span
                                        v-if="userForm.processing"
                                        class="loading loading-spinner loading-xs"
                                    ></span>
                                    {{
                                        isEditing
                                            ? 'Save Changes'
                                            : 'Update Profile'
                                    }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Password change section -->
                <div class="divider my-8">Password Settings</div>

                <form @submit.prevent="updatePassword">
                    <div v-if="!isChangingPassword" class="text-center">
                        <button
                            @click="isChangingPassword = true"
                            class="btn btn-outline btn-primary"
                        >
                            Change Password
                        </button>
                    </div>

                    <div
                        v-else
                        class="mx-auto grid max-w-lg grid-cols-1 gap-4 md:grid-cols-2"
                    >
                        <div class="form-field form-control md:col-span-2">
                            <label class="label">
                                <span class="label-text">Current Password</span>
                            </label>
                            <input
                                v-model="passwordForm.current_password"
                                type="password"
                                placeholder="Enter your current password"
                                class="input w-full focus-within:outline-none"
                                :class="{
                                    'input-error':
                                        passwordForm.errors.current_password,
                                }"
                            />
                            <label
                                v-if="passwordForm.errors.current_password"
                                class="label"
                            >
                                <span class="label-text-alt text-error">{{
                                    passwordForm.errors.current_password
                                }}</span>
                            </label>
                        </div>

                        <div class="form-field form-control">
                            <label class="label">
                                <span class="label-text">New Password</span>
                            </label>
                            <input
                                v-model="passwordForm.new_password"
                                type="password"
                                placeholder="Enter new password"
                                class="input w-full focus-within:outline-none"
                                :class="{
                                    'input-error':
                                        passwordForm.errors.new_password,
                                }"
                            />
                            <label
                                v-if="passwordForm.errors.new_password"
                                class="label"
                            >
                                <span class="label-text-alt text-error">{{
                                    passwordForm.errors.new_password
                                }}</span>
                            </label>
                        </div>

                        <div class="form-field form-control">
                            <label class="label">
                                <span class="label-text"
                                    >Confirm New Password</span
                                >
                            </label>
                            <input
                                v-model="passwordForm.new_password_confirmation"
                                type="password"
                                placeholder="Confirm new password"
                                class="input w-full focus-within:outline-none"
                                :class="{
                                    'input-error':
                                        passwordForm.errors
                                            .new_password_confirmation,
                                }"
                            />
                            <label
                                v-if="
                                    passwordForm.errors
                                        .new_password_confirmation
                                "
                                class="label"
                            >
                                <span class="label-text-alt text-error">{{
                                    passwordForm.errors
                                        .new_password_confirmation
                                }}</span>
                            </label>
                        </div>

                        <div
                            class="form-field mt-2 flex justify-center space-x-2 md:col-span-2"
                        >
                            <button
                                type="button"
                                @click="isChangingPassword = false"
                                class="btn btn-outline"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="btn btn-primary"
                                :disabled="
                                    passwordForm.processing ||
                                    !passwordForm.new_password ||
                                    passwordForm.new_password !==
                                        passwordForm.new_password_confirmation
                                "
                            >
                                <span
                                    v-if="passwordForm.processing"
                                    class="loading loading-spinner loading-xs"
                                ></span>
                                Update Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
