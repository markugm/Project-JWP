<?php include __DIR__ . '/_header.php'; ?>

<style>
    /*Essential CSS for the Sticky Footer*/
    body {
        /* 1. Make the body a flex container */
        display: flex;
        /* 2. Stack the children vertically */
        flex-direction: column;
        /* 3. Ensure the body takes up at least the full height of the viewport */
        min-height: 100vh;
        /* Optional: Remove default margin */
        margin: 0;
    }

    /* 4. Tell the main content area to take up all remaining space */
    main {
        flex-grow: 1;
    }
</style>


<section class="pb-10">
    <div class="relative isolate lg:px-8">
        <div class="mx-auto max-w-2xl py-10">
            <div class="text-center">
                <h1 class="text-5xl font-semibold tracking-tight text-balance sm:text-7xl">Data to enrich your online business</h1>
                <p class="mt-8 text-lg font-medium text-pretty text-gray-400 sm:text-xl/8">Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat.</p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="#" class="rounded-md bg-indigo-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Get started</a>
                    <a href="#" class="text-sm/6 font-semibold">Learn more <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>
        <div aria-hidden="true" class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
            <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-288.75"></div>
        </div>
    </div>
</section>

<section class="mb-12">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-full lg:mx-0 flex justify-between items-center">
            <h2 class="text-3xl font-semibold text-pretty text-black ">Artikel Terbaru</h2>
            <a href="articles.php" class="text-purple-700 hover:underline text-sm font-semibold shrink-0">Lihat Semua Artikel →</a>
        </div>
        <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 border-t border-gray-700 sm:mt-6 sm:pt-5 lg:mx-0 lg:max-w-none lg:grid-cols-3">
            <article class="flex max-w-xl flex-col items-start justify-between">
                <div class="flex items-center gap-x-4 text-xs">
                    <time datetime="2020-03-16" class="text-gray-600">Mar 16, 2020</time>
                </div>
                <div class="group relative grow">
                    <h3 class="mt-3 text-xl font-semibold text-black group-hover:text-purple-700">
                        <a href="#">
                            <span class="absolute inset-0"></span>
                            Boost your conversion rate
                        </a>
                    </h3>
                    <p class="mt-5 line-clamp-3 text-sm/6 text-gray-600">Illo sint voluptas. Error voluptates culpa eligendi. Hic vel totam vitae illo. Non aliquid explicabo necessitatibus unde. Sed exercitationem placeat consectetur nulla deserunt vel. Iusto corrupti dicta.</p>
                </div>
                <div class="relative mt-8 flex items-center gap-x-4 justify-self-end">
                    <img src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-10 rounded-full bg-gray-800" />
                    <div class="text-sm/6">
                        <p class="font-semibold text-black">
                            <a href="#">
                                <span class="absolute inset-0"></span>
                                Michael Foster
                            </a>
                        </p>
                        <p class="text-gray-400">Co-Founder / CTO</p>
                    </div>
                </div>
            </article>
            <article class="flex max-w-xl flex-col items-start justify-between">
                <div class="flex items-center gap-x-4 text-xs">
                    <time datetime="2020-03-16" class="text-gray-600">Mar 16, 2020</time>
                </div>
                <div class="group relative grow">
                    <h3 class="mt-3 text-xl font-semibold text-black group-hover:text-purple-700">
                        <a href="#">
                            <span class="absolute inset-0"></span>
                            Boost your conversion rate
                        </a>
                    </h3>
                    <p class="mt-5 line-clamp-3 text-sm/6 text-gray-600">Illo sint voluptas. Error voluptates culpa eligendi. Hic vel totam vitae illo. Non aliquid explicabo necessitatibus unde. Sed exercitationem placeat consectetur nulla deserunt vel. Iusto corrupti dicta.</p>
                </div>
                <div class="relative mt-8 flex items-center gap-x-4 justify-self-end">
                    <img src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-10 rounded-full bg-gray-800" />
                    <div class="text-sm/6">
                        <p class="font-semibold text-black">
                            <a href="#">
                                <span class="absolute inset-0"></span>
                                Michael Foster
                            </a>
                        </p>
                        <p class="text-gray-400">Co-Founder / CTO</p>
                    </div>
                </div>
            </article>
            <article class="flex max-w-xl flex-col items-start justify-between">
                <div class="flex items-center gap-x-4 text-xs">
                    <time datetime="2020-03-16" class="text-gray-600">Mar 16, 2020</time>
                </div>
                <div class="group relative grow">
                    <h3 class="mt-3 text-xl font-semibold text-black group-hover:text-purple-700">
                        <a href="#">
                            <span class="absolute inset-0"></span>
                            Boost your conversion rate
                        </a>
                    </h3>
                    <p class="mt-5 line-clamp-3 text-sm/6 text-gray-600">Illo sint voluptas. Error voluptates culpa eligendi. Hic vel totam vitae illo. Non aliquid explicabo necessitatibus unde. Sed exercitationem placeat consectetur nulla deserunt vel. Iusto corrupti dicta.</p>
                </div>
                <div class="relative mt-8 flex items-center gap-x-4 justify-self-end">
                    <img src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-10 rounded-full bg-gray-800" />
                    <div class="text-sm/6">
                        <p class="font-semibold text-black">
                            <a href="#">
                                <span class="absolute inset-0"></span>
                                Michael Foster
                            </a>
                        </p>
                        <p class="text-gray-400">Co-Founder / CTO</p>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>

<?php include __DIR__ . '/_footer.php'; ?>