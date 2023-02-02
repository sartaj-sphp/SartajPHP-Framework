#define FFI_SCOPE "SPHPTHREAD"
#define FFI_LIB "SphpThread.dll"

typedef int (*on_thread_run_t)(const char* str);
struct SphpThread1;
typedef struct SphpThread1 SphpThread2;
SphpThread2* SphpThread2__create();
void SphpThread2__destroy(SphpThread2 * self);
void addThread(SphpThread2* self,const char* strName);
void runThreadAll(SphpThread2 * self);
int isRunning(SphpThread2 * self);
void on_thread_run(SphpThread2 * self, on_thread_run_t handler);
const char* readStdinAsync(SphpThread2 * self);
