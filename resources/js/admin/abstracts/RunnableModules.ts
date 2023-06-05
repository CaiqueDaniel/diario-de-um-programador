import {Runnable} from "../interfaces";

export default abstract class RunnableModules implements Runnable {
    protected constructor(private modules: Runnable[]) {
    }

    public run(): void {
        this.modules.forEach(RunnableModules.invoke);
    }

    protected static invoke(runnable: Runnable): void {
        try {
            runnable.run();
        } catch (e) {
            console.error(e);
        }
    }
}
