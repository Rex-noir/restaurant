<script setup lang="ts">
import InputGroup from '@/Components/input-group.vue';
import ProfileImageUploader from '@/Components/profile-image-uploader.vue';
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
                        <ProfileImageUploader
                            v-model:image="userForm.profile.profile_image"
                        />
                        <!-- Profile details form -->
                        <div class="col-span-2">
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <InputGroup
                                    label="Name"
                                    v-model:input-text="userForm.name"
                                    :error="userForm.errors.name"
                                    placeholder="Your name"
                                />

                                <InputGroup
                                    label="Email"
                                    v-model:input-text="userForm.email"
                                    :error="userForm.errors.email"
                                    placeholder="Email"
                                />

                                <InputGroup
                                    label="Phone"
                                    v-model:input-text="userForm.profile.phone"
                                    input-type="tel"
                                    :error="
                                        deepGet(
                                            userForm.errors,
                                            'profile.phone',
                                            '',
                                        )
                                    "
                                    placeholder="Your phone number"
                                />
                                <InputGroup
                                    label="Date of Birth"
                                    v-model:input-text="
                                        userForm.profile.date_of_birth
                                    "
                                    input-type="date"
                                    :error="
                                        deepGet(
                                            userForm.errors,
                                            'profile.date_of_birth',
                                            '',
                                        )
                                    "
                                />

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
                        <InputGroup
                            class="col-span-2"
                            label="Current Password"
                            :error="passwordForm.errors.current_password"
                            v-model:input-text="passwordForm.current_password"
                            input-type="password"
                            placeholder="Enter your current password"
                        />

                        <InputGroup
                            label="New Password"
                            :error="passwordForm.errors.new_password"
                            v-model:input-text="passwordForm.new_password"
                            input-type="password"
                            placeholder="Enter your new password"
                        />

                        <InputGroup
                            label="New Password Confirmation"
                            :error="
                                passwordForm.errors.new_password_confirmation
                            "
                            v-model:input-text="
                                passwordForm.new_password_confirmation
                            "
                            input-type="password"
                            placeholder="Enter your new password again"
                        />

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
