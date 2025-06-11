<?php $__env->startSection('content'); ?>
    <div class="max-w-4xl mx-auto p-4">
        <!-- Avatar et bannière -->
        <div class="relative">
            <!--<img src="<?php echo e($user->banner); ?>" class="w-full h-40 object-cover rounded-lg" alt="Bannière">-->
            <?php if($user->avatar): ?>
                <div class="mb-2">
                    <img src="<?php echo e(Storage::url($user->avatar)); ?>" class="w-40 h-40 top-0 left-0 rounded-full border-4 border-white shadow-lg" alt="Avatar actuel">
                </div>
            <?php else: ?>
                <div class="mb-2">
                    <img src="<?php echo e(asset('images/profile.png')); ?>" class="w-40 h-40 top-0 left-0 rounded-full border-4 border-white shadow-lg" alt="Avatar actuel">
                </div>
            <?php endif; ?>
        </div>

        <!-- Informations de l'utilisateur -->
        <div class="mt-2 p-4">
            <h1 class="text-2xl font-bold text-white">
                <?php echo e($user->username); ?>

                <?php if($user->verified): ?>
                    <span class="text-blue-500">✔</span>
                <?php endif; ?>
            </h1>
            <p class="text-white"><?php echo e($user->name); ?> <?php echo e($user->lastname); ?></p>

            <!-- Bio -->
            <?php if($user->bio): ?>
                <p class="mt-2 text-white"><?php echo e($user->bio); ?></p>
            <?php endif; ?>

            <!-- Sports favoris -->
            <div class="mt-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Sports favoris :</h2>
                <?php if($user->favoriteSports->isEmpty()): ?>
                    <p class="text-gray-500 dark:text-gray-400">Aucun sport favori sélectionné.</p>
                <?php else: ?>
                    <ul class="list-disc list-inside mt-2">
                        <?php $__currentLoopData = $user->favoriteSports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="text-gray-700 dark:text-gray-300"><?php echo e($sport->name); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Team -->
            <div class="mt-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Team :</h2>
                <?php if($user->teams()->count() === 0): ?>
                    <p class="text-gray-500 dark:text-gray-400">Ne fais parti d'aucune équipe.</p>
                <?php else: ?>
                    <p class="text-blue-500">
                        <a href="<?php echo e(route('teams.show', $user->teams()->first()->id)); ?>" class="font-semibold hover:underline">
                        <?php echo e($user->teams()->first()->name); ?>

                        </a>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Localisation et date d'inscription -->
            <div class="mt-2 text-white flex items-center space-x-4">
                <?php if($user->location): ?>
                    <span>📍 <?php echo e($user->location); ?></span>
                <?php endif; ?>
                <span>&nbsp&nbsp&nbsp&nbsp📅 A rejoint en <?php echo e($user->created_at->format('F Y')); ?></span>
            </div>

            <!-- Nombre d'abonnés et d'abonnements -->
            <div class="mt-2 flex items-center space-x-4">
                <span class="font-bold text-white"><?php echo e($user->followers->count()); ?></span>
                <span class="text-white">abonnés,</span>
                <span class="font-bold text-white"><?php echo e($user->following->count()); ?></span>
                <span class="text-white">abonnements</span>
            </div>
        </div>

        <!-- Bouton Follow/Unfollow -->
        <?php if(Auth::check() && Auth::id() !== $user->id): ?>
            <div class="mt-6 mb-6">
                <?php if($isFollowing): ?>
                    <form action="<?php echo e(route('profile.unfollow', $user->username)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Ne plus suivre
                        </button>
                    </form>
                <?php else: ?>
                    <form action="<?php echo e(route('profile.follow', $user->username)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Suivre
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Bouton Modifier le profil (visible uniquement pour l'utilisateur connecté) -->
        <?php if(Auth::check() && Auth::id() === $user->id): ?>
            <div class="mt-6 mb-6">
                <a href="<?php echo e(route('profile.edit')); ?>"
                   class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Modifier le profil
                </a>
            </div>
        <?php endif; ?>

        <?php if (\Illuminate\Support\Facades\Blade::check('admin')): ?>
        <div class="mt-4 flex justify-end">
            <form action="<?php echo e(route('admin.users.delete', $user->id)); ?>" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Supprimer
                </button>
            </form>
        </div>
        <?php endif; ?>

        <!-- Navigation -->
        <div class="border-b">
            <div class="flex justify-around text-gray-500">
                <a href="<?php echo e(route('profile.show', $user->username)); ?>?tab=posts"
                   class="py-2 px-4 <?php echo e($tab === 'posts' ? 'font-bold text-white border-b-2 border-black' : ''); ?>">
                    Posts
                </a>
                <a href="<?php echo e(route('profile.show', $user->username)); ?>?tab=followers"
                   class="py-2 px-4 <?php echo e($tab === 'followers' ? 'font-bold text-white border-b-2 border-black' : ''); ?>">
                    Abonnés
                </a>
                <a href="<?php echo e(route('profile.show', $user->username)); ?>?tab=following"
                   class="py-2 px-4 <?php echo e($tab === 'following' ? 'font-bold text-white border-b-2 border-black' : ''); ?>">
                    Abonnements
                </a>
            </div>
        </div>

        <!-- Contenu de l'onglet -->
        <div class="mt-4">
            <?php if($tab === 'posts'): ?>
                <!-- Liste des posts -->
                <?php $__empty_1 = true; $__currentLoopData = $user->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-4 border-b">
                        <!-- Titre du post -->
                        <?php if($post->title): ?>
                            <h3 class="text-lg font-semibold text-white"><?php echo e($post->title); ?></h3>
                        <?php endif; ?>

                        <!-- Contenu du post -->
                        <p class="mt-2 text-white"><?php echo e($post->content); ?></p>

                        <!-- Image du post -->
                        <?php if($post->image): ?>
                            <div class="mt-2">
                                <img src="<?php echo e(asset('storage/' . $post->image)); ?>" class="w-100 h-100 object-contain rounded-lg" alt="Image du post">
                            </div>
                        <?php endif; ?>

                        <!-- Date de publication -->
                        <div class="text-white text-sm mt-2"><?php echo e($post->created_at->diffForHumans()); ?></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-4 text-white">
                        Aucun post pour le moment.
                    </div>
                <?php endif; ?>

            <?php elseif($tab === 'followers'): ?>
                <!-- Liste des abonnés -->
                <?php $__empty_1 = true; $__currentLoopData = $user->followers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $follower): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-4 border-b flex items-center space-x-4">
                        <img src="<?php echo e(Storage::url($follower->avatar) ?? asset('images/profile.png')); ?>" class="w-12 h-12 rounded-full" alt="Avatar de l'abonné">
                        <div>
                            <a href="<?php echo e(route('profile.show', $follower->username)); ?>" class="font-semibold text-white hover:underline">
                                <?php echo e($follower->username); ?>

                                <?php if($follower->verified): ?>
                                    <span class="text-blue-500">✔</span>
                                <?php endif; ?>
                            </a>
                            <p class="text-white"><?php echo e($follower->name); ?> <?php echo e($follower->lastname); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-4 text-white">
                        Aucun abonné pour le moment.
                    </div>
                <?php endif; ?>

            <?php elseif($tab === 'following'): ?>
                <!-- Liste des abonnements -->
                <?php $__empty_1 = true; $__currentLoopData = $user->following; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $followed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-4 border-b flex items-center space-x-4">
                        <img src="<?php echo e(Storage::url($followed->avatar) ?? asset('images/profile.png')); ?>" class="w-12 h-12 rounded-full" alt="Avatar de l'abonnement">
                        <div>
                            <a href="<?php echo e(route('profile.show', $followed->username)); ?>" class="font-semibold text-white hover:underline">
                                <?php echo e($followed->username); ?>

                                <?php if($followed->verified): ?>
                                    <span class="text-blue-500">✔</span>
                                <?php endif; ?>
                            </a>
                            <p class="text-white"><?php echo e($followed->name); ?> <?php echo e($followed->lastname); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-4 text-white">
                        Aucun abonnement pour le moment.
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/profile/index.blade.php ENDPATH**/ ?>