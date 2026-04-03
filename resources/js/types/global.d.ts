interface EchoChannel {
    notification(callback: (notification: any) => void): this;
}

interface Echo {
    private(channel: string): EchoChannel;
    leave(channel: string): void;
}

declare global {
    interface Window {
        axios: AxiosInstance;
        Pusher: typeof Pusher;
        Echo: Echo; 
    }
}

export {};