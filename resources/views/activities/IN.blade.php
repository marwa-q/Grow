<script>
    document.addEventListener("DOMContentLoaded", function () {
        // معالجة نماذج الانضمام
        document.querySelectorAll(".join-form").forEach(form => {
            form.addEventListener("submit", function (event) {
                event.preventDefault();
                
                // الحصول على عناصر النموذج
                const formData = new FormData(this);
                const button = this.querySelector(".book-button");
                const formAction = this.getAttribute("action");
                const activityId = this.id.replace("join-form-", "");
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                
             
                
                // إرسال طلب الانضمام باستخدام FormData بدلاً من JSON
                fetch(formAction, {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        // لا نحدد Content-Type هنا لأن fetch سيقوم بتعيينه تلقائيًا مع FormData
                    },
                    body: formData
                })
                .then(response => {
                    // التحقق من نجاح الاستجابة
                    if (!response.ok) {
                        throw new Error("فشل الاتصال بالخادم. الرمز: " + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    // إعادة الزر إلى حالته الأصلية
                    button.disabled = false;
                    
                    if (data.success) {
                        // نجاح الانضمام
                        Swal.fire({
                            title: "✅ تم الانضمام",
                            text: data.message || "تم الانضمام بنجاح",
                            icon: "success",
                            confirmButtonText: "حسنًا"
                        });
                        
                        // تغيير حالة الزر إلى "إلغاء الاشتراك"
                        button.textContent = "إلغاء الاشتراك";
                        button.classList.add("leave-button");
                        
                        // تغيير السمات للنموذج
                        this.classList.remove("join-form");
                        this.classList.add("leave-form");
                        this.id = "leave-form-" + activityId;
                        
                        // تحديث مسار النموذج لإلغاء الاشتراك
                        const leaveUrl = formAction.replace("join.activity", "leave.activity");
                        this.setAttribute("action", leaveUrl);
                        
                        // إضافة معالج حدث إلغاء الاشتراك
                        this.removeEventListener("submit", arguments.callee);
                        setupLeaveForm(this);
                    } else {
                        // فشل الانضمام
                        button.textContent = originalButtonText;
                        Swal.fire({
                            title: "⚠️ خطأ!",
                            text: data.message || "حدث خطأ أثناء محاولة الانضمام",
                            icon: "error",
                            confirmButtonText: "حسنًا"
                        });
                    }
                })
                .catch(error => {
                    // استعادة حالة الزر
                    button.disabled = false;
                    button.textContent = originalButtonText;
                    
                    // عرض رسالة الخطأ
                    console.error("Error:", error);
                    Swal.fire({
                        title: "⚠️ خطأ في الاتصال",
                        text: "تعذر الاتصال بالخادم، يرجى المحاولة مرة أخرى",
                        icon: "error",
                        confirmButtonText: "حسنًا"
                    });
                });
            });
        });
        
        // معالجة نماذج إلغاء الاشتراك
        document.querySelectorAll(".leave-form").forEach(form => {
            setupLeaveForm(form);
        });
        
        // دالة مساعدة لإعداد نموذج إلغاء الاشتراك
        function setupLeaveForm(form) {
            form.addEventListener("submit", function (event) {
                event.preventDefault();
                
                const formData = new FormData(this);
                const button = this.querySelector(".leave-button") || this.querySelector(".book-button");
                const formAction = this.getAttribute("action");
                const activityId = this.id.replace("leave-form-", "");
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                
                // تأكيد إلغاء الاشتراك
                Swal.fire({
                    title: "هل أنت متأكد؟",
                    text: "هل ترغب في إلغاء الاشتراك من هذا النشاط؟",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "نعم، إلغاء الاشتراك",
                    cancelButtonText: "لا، العودة"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // المستخدم أكد الإلغاء
                        const originalButtonText = button.textContent;
                        button.textContent = "جاري الإلغاء...";
                        button.disabled = true;
                        
                        fetch(formAction, {
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error("فشل الاتصال بالخادم. الرمز: " + response.status);
                            }
                            return response.json();
                        })
                        .then(data => {
                            button.disabled = false;
                            
                            if (data.success) {
                                Swal.fire({
                                    title: "✅ تم الإلغاء",
                                    text: data.message || "تم إلغاء الاشتراك بنجاح",
                                    icon: "info",
                                    confirmButtonText: "حسنًا"
                                });
                                
                                // تغيير الزر إلى "انضمام"
                                button.textContent = "الانضمام";
                                button.classList.remove("leave-button");
                                
                                // تغيير سمات النموذج
                                form.classList.remove("leave-form");
                                form.classList.add("join-form");
                                form.id = "join-form-" + activityId;
                                
                                // تحديث مسار النموذج للانضمام
                                const joinUrl = formAction.replace("leave.activity", "join.activity");
                                form.setAttribute("action", joinUrl);
                                
                                // إضافة معالج حدث الانضمام
                                form.removeEventListener("submit", arguments.callee);
                                
                                // إعادة تطبيق معالج الانضمام
                                form.addEventListener("submit", function(e) {
                                    e.preventDefault();
                                    const joinFormData = new FormData(this);
                                    const joinButton = this.querySelector(".book-button");
                                    const joinAction = this.getAttribute("action");
                                    
                                    // عرض مؤشر التحميل
                                    const originalJoinText = joinButton.textContent;
                                    joinButton.textContent = "جاري الانضمام...";
                                    joinButton.disabled = true;
                                    
                                    fetch(joinAction, {
                                        method: "POST",
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken
                                        },
                                        body: joinFormData
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error("فشل الاتصال بالخادم. الرمز: " + response.status);
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        joinButton.disabled = false;
                                        
                                        if (data.success) {
                                            Swal.fire({
                                                title: "✅ تم الانضمام",
                                                text: data.message || "تم الانضمام بنجاح",
                                                icon: "success",
                                                confirmButtonText: "حسنًا"
                                            });
                                            
                                            // إعادة الزر إلى حالة "إلغاء الاشتراك"
                                            joinButton.textContent = "إلغاء الاشتراك";
                                            joinButton.classList.add("leave-button");
                                            
                                            // تحديث النموذج مرة أخرى
                                            this.classList.remove("join-form");
                                            this.classList.add("leave-form");
                                            this.id = "leave-form-" + activityId;
                                            
                                            // تحديث مسار النموذج لإلغاء الاشتراك مرة أخرى
                                            const leaveUrlAgain = joinAction.replace("join.activity", "leave.activity");
                                            this.setAttribute("action", leaveUrlAgain);
                                            
                                            // تطبيق معالج إلغاء الاشتراك
                                            this.removeEventListener("submit", arguments.callee);
                                            setupLeaveForm(this);
                                        } else {
                                            joinButton.textContent = originalJoinText;
                                            Swal.fire({
                                                title: "⚠️ خطأ!",
                                                text: data.message || "حدث خطأ أثناء محاولة الانضمام",
                                                icon: "error",
                                                confirmButtonText: "حسنًا"
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        joinButton.disabled = false;
                                        joinButton.textContent = originalJoinText;
                                        console.error("Error:", error);
                                        Swal.fire({
                                            title: "⚠️ خطأ في الاتصال",
                                            text: "تعذر الاتصال بالخادم، يرجى المحاولة مرة أخرى",
                                            icon: "error",
                                            confirmButtonText: "حسنًا"
                                        });
                                    });
                                });
                            } else {
                                button.textContent = originalButtonText;
                                Swal.fire({
                                    title: "⚠️ خطأ!",
                                    text: data.message || "حدث خطأ أثناء محاولة إلغاء الاشتراك",
                                    icon: "error",
                                    confirmButtonText: "حسنًا"
                                });
                            }
                        })
                        .catch(error => {
                            button.disabled = false;
                            button.textContent = originalButtonText;
                            console.error("Error:", error);
                            
                            Swal.fire({
                                title: "⚠️ خطأ في الاتصال",
                                text: "تعذر الاتصال بالخادم، يرجى المحاولة مرة أخرى",
                                icon: "error",
                                confirmButtonText: "حسنًا"
                            });
                        });
                    }
                });
            });
        }
    });
</script>