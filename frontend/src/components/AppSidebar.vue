<script setup lang="ts">
import { Calendar, Home, Clock } from "lucide-vue-next"
import {
  Sidebar,
  SidebarContent,
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from "@/components/ui/sidebar"

const items = [
  {
    title: "Acceuil",
    url: "/",
    icon: Home,
  },
  {
    title: "Evènement",
    url: "/event",
    icon: Calendar,
  },
  {
    title: "Réservation",
    url: "/reservation",
    icon: Clock,
  },
]
</script>

<template>
  <div class="flex h-screen">
   
    <Sidebar>
      <SidebarContent>
        <SidebarGroup>
          <SidebarGroupLabel>Application</SidebarGroupLabel>
          <SidebarGroupContent>
            <SidebarMenu>
              <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton asChild>
                  <router-link :to="item.url" class="flex items-center gap-2">
                    <component :is="item.icon" class="w-5 h-5" />
                    <span>{{ item.title }}</span>
                  </router-link>
                </SidebarMenuButton>
              </SidebarMenuItem>
            </SidebarMenu>
          </SidebarGroupContent>
        </SidebarGroup>
      </SidebarContent>
    </Sidebar>

   
    <main class="mx-20 overflow-y-auto">
      <router-view />
    </main>
  </div>
</template>
