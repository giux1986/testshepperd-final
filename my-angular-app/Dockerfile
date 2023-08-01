# Stage 1: Build Angular app
FROM node:16 AS builder

WORKDIR /app
COPY . .

RUN npm install
RUN npm run build --prod

# Stage 2: Serve Angular app
FROM nginx:alpine

COPY --from=builder /app/dist/my-angular-app /usr/share/nginx/html
